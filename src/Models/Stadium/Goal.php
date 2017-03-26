<?php

namespace ReplayParser\Models\Stadium;

use ReplayParser\Reader;
use ReplayParser\Models\Stadium;
use ReplayParser\Models\ParseableModelInterface;

class Goal implements ParseableModelInterface
{
    private $posStart;
    private $posEnd;
    private $team;

    public static function parse(Reader $reader)
    {
        $goal = new self;

        $goal->setPosStart($reader->readDouble(), $reader->readDouble())
            ->setPosEnd($reader->readDouble(), $reader->readDouble())
            ->setTeam(Stadium::parseTeam($reader->readUInt8() ? 1 : 2));

        return $goal;
    }

    public function jsonSerialize()
    {
        return [
            'p0' => $this->posStart,
            'p1' => $this->posEnd,
            'team' => $this->team
        ];
    }

    public function setPosStart($x, $y)
    {
        $this->posStart = [$x, $y];
        return $this;
    }

    public function getPosStart()
    {
        return $this->posStart;
    }

    public function setPosEnd($x, $y)
    {
        $this->posEnd = [$x, $y];
        return $this;
    }

    public function getPosEnd()
    {
        return $this->posEnd;
    }

    public function setTeam($team)
    {
        $this->team = $team;
        return $this;
    }

    public function getTeam()
    {
        return $this->team;
    }
}
