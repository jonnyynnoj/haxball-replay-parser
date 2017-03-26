<?php

namespace ReplayParser\Models\Stadium;

use ReplayParser\Reader;
use ReplayParser\Models\Stadium;

class BallPhysics extends MaskedItem
{
    private $radius;
    private $bCoef;
    private $invMass;
    private $damping;
    private $color;

    public static function parse(Reader $reader)
    {
        return (new self)->setRadius($reader->readDouble())
            ->setBCoef($reader->readDouble())
            ->setInvMass($reader->readDouble())
            ->setDamping($reader->readDouble())
            ->setColor(dechex($reader->readUInt32()))
            ->setCMask(Stadium::parseMask($reader->readUInt32()))
            ->setCGroup(Stadium::parseMask($reader->readUInt32()));
    }

    public function jsonSerialize()
    {
        $data = [];

        if ($this->radius > 0) {
            $data['radius'] = $this->radius;
        }

        if ($this->bCoef > 0) {
            $data['bCoef'] = $this->bCoef;
        }

        if ($this->damping) {
            $data['damping'] = $this->damping;
        }

        if ($this->color) {
            $data['color'] = $this->color;
        }

        if (!empty($this->cMask)) {
            $data['cMask'] = $this->cMask;
        }

        if (!empty($this->cGroup)) {
            $data['cGroup'] = $this->cGroup;
        }

        return $data;
    }

    public function setRadius($radius)
    {
        $this->radius = $radius;
        return $this;
    }

    public function getRadius()
    {
        return $this->radius;
    }

    public function setBCoef($bCoef)
    {
        $this->bCoef = $bCoef;
        return $this;
    }

    public function getBCoef()
    {
        return $this->bCoef;
    }

    public function setInvMass($invMass)
    {
        $this->invMass = $invMass;
        return $this;
    }

    public function getInvMass()
    {
        return $this->invMass;
    }

    public function setDamping($damping)
    {
        $this->damping = $damping;
        return $this;
    }

    public function getDamping()
    {
        return $this->damping;
    }

    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }
}
