<?php

namespace ReplayParser\Models\Stadium;

use ReplayParser\Models\ParseableModelInterface;

abstract class MaskedItem implements ParseableModelInterface
{
    protected $cMask;
    protected $cGroup;

    public function setCMask(array $masks)
    {
        $this->cMask = $masks;
        return $this;
    }

    public function getCMask()
    {
        return $this->cMask;
    }

    public function setCGroup(array $masks)
    {
        $this->cGroup = $masks;
        return $this;
    }

    public function getCGroup()
    {
        return $this->cGroup;
    }
}
