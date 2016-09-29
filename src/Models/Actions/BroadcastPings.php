<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class BroadcastPings extends Action
{
    private $pings;

    protected $type = 'broadcastPings';

    public static function parse(Reader $reader)
    {
        $num = $reader->readUint8();
        $pings = [];

        for ($i = 0; $i < $num; ++$i) {
            $pings[] = $reader->readUint8();
        }

        $action = (new self)->setPings($pings);
        return $action;
    }

    protected function getData()
    {
        return ['pings' => $this->pings];
    }

    public function setPings(array $pings)
    {
        $this->pings = $pings;
        return $this;
    }

    public function getPings()
    {
        return $this->pings;
    }

}
