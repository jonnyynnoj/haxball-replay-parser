<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Models\Stadium;
use ReplayParser\Models\TeamColor;
use ReplayParser\Reader;

class ChangeColors extends Action
{
    private $team;
    private $color;

    protected $type = 'changeColors';

    public static function parse(Reader $reader)
    {
        $action = (new self)->setTeam($reader->readUint8());
        $color = new TeamColor;

        $numStripes = $reader->readUint8();
        $stripes = [];

        for ($i = 0; $i < $numStripes; ++$i) {
            $stripes[] = dechex($reader->readUint32());
        }

        $color->setStripes($stripes)
            ->setAngle($reader->readUInt16())
            ->setTextColor(dechex($reader->readUint32()));

        $action->setColor($color);
        return $action;
    }

    protected function getData()
    {
        return [
            'team' => $this->team,
            'color' => $this->color
        ];
    }

    public function setTeam($team)
    {
        if (!in_array($team, Stadium::$teams)) {
            $team = Stadium::parseTeam($team);
        }

        $this->team = $team;
        return $this;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function setColor(TeamColor $color)
    {
        $this->color = $color;
        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }
}
