<?php

namespace ReplayParser\Models;

use ReplayParser\Reader;

interface ParseableModelInterface extends \JsonSerializable
{
    public static function parse(Reader $reader);
}
