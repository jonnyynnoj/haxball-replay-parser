<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class PlayerLeft extends Action
{
    private $id;
    private $kicked = false;
    private $banned = false;
    private $kickReason = '';

    protected $type = 'playerLeft';

    public static function parse(Reader $reader)
    {
        $action = (new self)->setId($reader->readUint16())
            ->setKicked($reader->readUint8());

        if ($action->wasKicked()) {
            $action->setKickReason($reader->readStringAuto());
        }

        $action->setBanned($reader->readUint8());

        return $action;
    }

    protected function getData()
    {
        return [
            'id' => $this->id,
            'kicked' => $this->kicked,
            'kickReason' => $this->kickReason,
            'banned' => $this->banned
        ];
    }

    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setKicked($state)
    {
        $this->kicked = (bool) $state;
        return $this;
    }

    public function wasKicked()
    {
        return $this->kicked;
    }

    public function setKickReason($reason)
    {
        $this->kickReason = (string) $reason;
        return $this;
    }

    public function getKickReason()
    {
        return $this->kickReason;
    }

    public function setBanned($state)
    {
        $this->banned = (bool) $state;
        return $this;
    }

    public function wasBanned()
    {
        return $this->banned;
    }
}
