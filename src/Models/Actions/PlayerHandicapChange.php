<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class PlayerHandicapChange extends Action
{
    private $handicap;

    protected $type = 'playerHandicapChange';

    public static function parse(Reader $reader)
    {
        return (new self)->setHandicap($reader->readUint16());
    }

    protected function getData()
    {
        return ['handicap' => $handicap];
    }

    public function setHandicap($handicap)
    {
        $this->handicap = (int) $handicap;
        return $this;
    }

    public function getHandicap()
    {
        return $this->handicap;
    }
}
