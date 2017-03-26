<?php

namespace ReplayParser\Models;

use ReplayParser\Models\Actions\NewPlayer;
use ReplayParser\Reader;

abstract class Action implements ParseableModelInterface
{
    protected $type;
    protected $frame;
    protected $sender;

    public static function parse(Reader $reader)
    {
        return new static;
    }

    public function jsonSerialize()
    {
        return [
            'type' => $this->type,
            'frame' => $this->frame,
            'replayTime' => $this->getReplayTime(),
            'sender' => $this->sender,
            'info' => $this->getData()
        ];
    }

    public function setFrame($frame)
    {
        $this->frame = (int) $frame;
        return $this;
    }

    public function getFrame()
    {
        return $this->frame;
    }

    public function getReplayTime()
    {
        return round($this->frame / 60, 2);
    }

    public function setSender($sender)
    {
        $this->sender = (int) $sender;
        return $this;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getType()
    {
        return $this->type;
    }

    abstract protected function getData();
}
