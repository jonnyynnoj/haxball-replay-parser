<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class ChangePaused extends Action
{
    private $paused;

    protected $type = 'changePaused';

    public static function parse(Reader $reader)
    {
        return (new self)->setPaused($reader->readUint8());
    }

    protected function getData()
    {
        return ['paused' => $this->paused];
    }

    public function setPaused($paused)
    {
        $this->paused = (bool) $paused;
        return $this;
    }

    public function isPaused()
    {
        return $this->paused;
    }
}
