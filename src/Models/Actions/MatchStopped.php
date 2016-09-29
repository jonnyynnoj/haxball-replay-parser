<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class MatchStopped extends Action
{
    protected $type = 'matchStopped';

    protected function getData()
    {
        return [];
    }
}
