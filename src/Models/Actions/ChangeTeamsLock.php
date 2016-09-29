<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class ChangeTeamsLock extends Action
{
    private $locked;

    protected $type = 'changeTeamsLock';

    public static function parse(Reader $reader)
    {
        return (new self)->setLocked($reader->readUint8());
    }

    protected function getData()
    {
        return ['locked' => $locked];
    }

    public function setLocked($locked)
    {
        $this->locked = (bool) $locked;
        return $this;
    }

    public function isLocked()
    {
        return $this->locked;
    }
}
