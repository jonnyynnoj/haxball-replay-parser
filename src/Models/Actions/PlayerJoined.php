<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Models\Player;
use ReplayParser\Reader;

class PlayerJoined extends Action implements \JsonSerializable
{
    private $player;

    protected $type = 'playerJoined';

    public static function parse(Reader $reader)
    {
        $action = new self;

        $player = new Player;
        $player->setId($reader->readUInt32())
            ->setName($reader->readStringAuto())
            ->setIsAdmin($reader->readUint8())
            ->setCountry($reader->readStringAuto());

        $action->setPlayer($player);
        return $action;
    }

    protected function getData()
    {
        return ['player' => $this->player];
    }

    public function setPlayer(Player $player)
    {
        $this->player = $player;
        return $this;
    }

    public function getPlayer()
    {
        return $this->player;
    }
}
