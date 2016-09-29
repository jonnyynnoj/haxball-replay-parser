<?php

namespace ReplayParser\Models\Stadium;

class MaskedItem
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
