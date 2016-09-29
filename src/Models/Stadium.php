<?php

namespace ReplayParser\Models;

use ReplayParser\Reader;
use ReplayParser\Models\Stadium\Background;
use ReplayParser\Models\Stadium\BallPhysics;
use ReplayParser\Models\Stadium\Disc;
use ReplayParser\Models\Stadium\Goal;
use ReplayParser\Models\Stadium\Plane;
use ReplayParser\Models\Stadium\PlayerPhysics;
use ReplayParser\Models\Stadium\Segment;
use ReplayParser\Models\Stadium\Vertex;

class Stadium implements \JsonSerializable
{
    private $name;
    private $custom = false;

    private $width;
    private $height;
    private $spawnDistance;
    private $background;
    private $playerPhysics;
    private $ballPhysics;
    private $vertexes = [];
    private $segments = [];
    private $planes = [];
    private $goals = [];
    private $discs = [];

    private static $stadiums = [
        'Classic',
        'Easy',
        'Small',
        'Big',
        'Rounded',
        'Hockey',
        'Big Hockey',
        'Big Easy',
        'Big Rounded',
        'Huge'
    ];

    private static $masks = [
        1 => 'ball',
        2 => 'red',
        4 => 'blue',
        8 => 'redKO',
        16 => 'blueKO',
        32 => 'wall'
    ];

    public static $teams = [
        'Spectators',
        'Red',
        'Blue'
    ];

    public static function parse(Reader $reader)
    {
        $stadium = new self;
        $type = $reader->readUInt8();

        if (isset(self::$stadiums[$type])) {
            $stadium->setName(self::$stadiums[$type]);
            return $stadium;
        }

        $stadium->setCustom(true)
            ->setName($reader->readStringAuto())
            ->setBackground(Background::parse($reader))
            ->setWidth($reader->readDouble())
            ->setHeight($reader->readDouble())
            ->setSpawnDistance($reader->readDouble())
            ->setVertexes(self::parseMultiple($reader, Vertex::class))
            ->setSegments(self::parseMultiple($reader, Segment::class))
            ->setPlanes(self::parseMultiple($reader, Plane::class))
            ->setGoals(self::parseMultiple($reader, Goal::class))
            ->setDiscs(self::parseMultiple($reader, Disc::class))
            ->setPlayerPhysics(PlayerPhysics::parse($reader))
            ->setBallPhysics(BallPhysics::parse($reader));

        return $stadium;
    }

    protected static function parseMultiple(Reader $reader, $type)
    {
        $items = [];
        $num = $reader->readUInt8();

        for ($i = 0; $i < $num; ++$i) {
            $items[] = $type::parse($reader);
        }

        return $items;
    }

    public function jsonSerialize()
    {
        $info = [
            'name' => $this->name,
            'custom' => $this->custom
        ];

        if ($this->isCustom()) {
            $info = array_merge($info, [
                'bg' => $this->background,
                'playerPhysics' => $this->playerPhysics,
                'ballPhysics' => $this->ballPhysics,
                'vertexes' => $this->vertexes,
                'segments' => $this->segments,
                'goals' => $this->goals,
                'discs' => $this->discs
            ]);
        }

        return $info;
    }

    public static function parseMask($int)
    {
        if ($int == -1) {
            return ['all'];
        }

        $masks = [];

        foreach (array_reverse(self::$masks, true) as $key => $mask) {
            if ($int & $key) {
                $masks[] = $mask;
            }
        }

        return $masks;
    }

    public static function parseTeam($team)
    {
        return isset(self::$teams[$team]) ? self::$teams[$team] : self::$teams[0];
    }

    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCustom($custom)
    {
        $this->custom = (bool) $custom;
        return $this;
    }

    public function isCustom()
    {
        return $this->custom;
    }

    public function setWidth($width)
    {
        $this->width = (float) $width;
        return $this;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setHeight($height)
    {
        $this->height = (float) $height;
        return $this;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setBackground(Background $background)
    {
        $this->background = $background;
        return $this;
    }

    public function getBackground()
    {
        return $this->background;
    }

    public function setSpawnDistance($spawnDistance)
    {
        $this->spawnDistance = (float) $spawnDistance;
        return $this;
    }

    public function getSpawnDistance()
    {
        return $this->spawnDistance;
    }

    public function setPlayerPhysics(PlayerPhysics $physics)
    {
        $this->playerPhysics = $physics;
        return $this;
    }

    public function getPlayerPhysics()
    {
        return $this->playerPhysics;
    }

    public function setBallPhysics($ballPhysics)
    {
        $this->ballPhysics = $ballPhysics;
        return $this;
    }

    public function getBallPhysics()
    {
        return $this->ballPhysics;
    }

    public function setVertexes(array $vertexes)
    {
        $this->vertexes = $vertexes;
        return $this;
    }

    public function getVertexes()
    {
        return $this->vertexes;
    }

    public function setSegments(array $segments)
    {
        $this->segments = $segments;
        return $this;
    }

    public function getSegments()
    {
        return $this->segments;
    }

    public function setPlanes(array $planes)
    {
        $this->planes = $planes;
        return $this;
    }

    public function getPlanes()
    {
        return $this->planes;
    }

    public function setGoals(array $goals)
    {
        $this->goals = $goals;
        return $this;
    }

    public function getGoals()
    {
        return $this->goals;
    }

    public function setDiscs(array $discs)
    {
        $this->discs = $discs;
        return $this;
    }

    public function getDiscs()
    {
        return $this->discs;
    }
}
