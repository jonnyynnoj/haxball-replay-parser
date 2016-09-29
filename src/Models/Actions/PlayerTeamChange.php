<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Models\Stadium;
use ReplayParser\Reader;

class PlayerTeamChange extends Action
{
    private $player;
    private $team;

    protected $type = 'changeTeam';

    public static function parse(Reader $reader)
    {
        $action = (new self)->setPlayer($reader->readUInt32())
            ->setTeam($reader->readUint8());

        return $action;
    }

    protected function getData()
    {
        return [
            'player' => $this->player,
            'team' => $this->team
        ];
    }

    public function setPlayer($player)
    {
        $this->player = (int) $player;
        return $this;
    }

    public function getPlayer()
    {
        return $this->player;
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
}
