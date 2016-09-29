<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class MatchStart extends Action
{
    protected $type = 'matchStart';

    protected function getData()
    {
        return [];
    }
}
