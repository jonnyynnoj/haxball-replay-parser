<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class LogicUpdate extends Action
{
    protected $type = 'logicUpdate';

    protected function getData()
    {
        return [];
    }
}
