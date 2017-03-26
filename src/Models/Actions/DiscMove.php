<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class DiscMove extends Action implements \JsonSerializable
{
    private static $moves = [
        'up' => 1,
        'down' => 2,
        'left' => 4,
        'right' => 8,
        'kick' => 16
    ];

    protected $type = 'discMove';

    public static function parse(Reader $reader)
    {
        $action = (new self)->setMove($reader->readUint8());
        return $action;
    }

    protected function getData()
    {
        return [
            'int' => $this->move,
            'moves' => $this->getMoveTypes()
        ];
    }

    public function setMove($move)
    {
        $this->move = (int) $move;
        return $this;
    }

    public function getRawMove()
    {
        return $this->move;
    }

    public function getMoveTypes()
    {
        $moves = [];

        foreach (array_reverse(self::$moves, true) as $move => $mask) {
            if ($this->move & $mask) {
                $moves[] = $move;
            }
        }

        return $moves;
    }

    public function movedUp()
    {
        return ($this->move & self::$moves['up']) > 0;
    }

    public function movedDown()
    {
        return ($this->move & self::$moves['down']) > 0;
    }

    public function movedLeft()
    {
        return ($this->move & self::$moves['left']) > 0;
    }

    public function movedRight()
    {
        return ($this->move & self::$moves['right']) > 0;
    }

    public function kicked()
    {
        return ($this->move & self::$moves['kick']) > 0;
    }
}
