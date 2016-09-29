<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class DiscMove extends Action implements \JsonSerializable
{
    private static $moves = [
        1 => 'up',
        2 => 'down',
        4 => 'left',
        8 => 'right',
        16 => 'kick'
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
            'moves' => $this->getMovesTypes()
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

        foreach (array_reverse(self::$moves, true) as $key => $mask) {
            if ($this->move & $key) {
                $moves[] = $mask;
            }
        }

        return $moves;
    }
}
