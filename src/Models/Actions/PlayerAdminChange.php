<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class PlayerAdminChange extends Action
{
    private $player;
    private $admin;

    protected $type = 'playerAdminChange';

    public static function parse(Reader $reader)
    {
        $action = (new self)->setPlayer($reader->readUInt32())
            ->setAdmin($reader->readUint8());

        return $action;
    }

    protected function getData()
    {
        return [
            'player' => $this->player,
            'admin' => $this->admin
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

    public function setAdmin($admin)
    {
        $this->admin = (bool) $admin;
        return $this;
    }

    public function isAdmin()
    {
        return $this->admin;
    }
}
