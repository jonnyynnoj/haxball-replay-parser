<?php

namespace ReplayParser\Models\Stadium;

use ReplayParser\Reader;
use ReplayParser\Models\Stadium;

class BallPhysics extends MaskedItem implements \JsonSerializable
{
    private $radius;
    private $bCoef;
    private $invMass;
    private $damping;
    private $color;

    public static function parse(Reader $reader)
    {
        $physics = new self;

        $physics->setRadius($reader->readDouble())
            ->setBCoef($reader->readDouble())
            ->setInvMass($reader->readDouble())
            ->setDamping($reader->readDouble())
            ->setColor(dechex($reader->readUInt32()))
            ->setCMask(Stadium::parseMask($reader->readUInt32()))
            ->setCGroup(Stadium::parseMask($reader->readUInt32()));

        return $physics;
    }

    public function jsonSerialize()
    {
        return [
            'radius' => $this->radius,
            'bCoef' => $this->bCoef,
            'invMass' => $this->invMass,
            'damping' => $this->damping,
            'color' => $this->color,
            'cMask' => $this->cMask,
            'cGroup' => $this->cGroup
        ];
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
