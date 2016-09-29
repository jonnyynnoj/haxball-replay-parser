<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class Desynced extends Action
{
    protected $type = 'desynced';

    protected function getData()
    {
        return [];
    }
}
