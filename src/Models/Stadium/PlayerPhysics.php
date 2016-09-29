<?php

namespace ReplayParser\Models\Stadium;

use ReplayParser\Reader;

class PlayerPhysics implements \JsonSerializable
{
    private $bCoef;
    private $invMass;
    private $damping;
    private $acceleration;
    private $kickingAcceleration;
    private $kickingDamping;
    private $kickingStrength;

    public static function parse(Reader $reader)
    {
        $physics = new self;

        $physics->setBCoef($reader->readDouble())
            ->setInvMass($reader->readDouble())
            ->setInvMass($reader->readDouble())
            ->setDamping($reader->readDouble())
            ->setAcceleration($reader->readDouble())
            ->setKickingAcceleration($reader->readDouble())
            ->setKickingDamping($reader->readDouble())
            ->setKickingStrength($reader->readDouble());

        return $physics;
    }

    public function jsonSerialize()
    {
        return [
            'bCoef' => $this->bCoef,
			'invMass' => $this->invMass,
			'damping' => $this->damping,
			'acceleration' => $this->acceleration,
			'kickingAcceleration' => $this->kickingAcceleration,
			'kickingDamping' => $this->kickingDamping,
			'kickStrength' => $this->kickingStrength
        ];
    }

    public function setBCoef($bCoef)
    {
        $this->bCoef = (float) $bCoef;
        return $this;
    }

    public function getBCoef()
    {
        return $this->bCoef;
    }

    public function setInvMass($invMass)
    {
        $this->invMass = (float) $invMass;
        return $this;
    }

    public function getInvMass()
    {
        return $this->invMass;
    }

    public function setDamping($damping)
    {
        $this->damping = (float) $damping;
        return $this;
    }

    public function getDamping()
    {
        return $this->damping;
    }

    public function setAcceleration($acceleration)
    {
        $this->acceleration = (float) $acceleration;
        return $this;
    }

    public function getAcceleration()
    {
        return $this->acceleration;
    }

    public function setKickingAcceleration($kickingAcceleration)
    {
        $this->kickingAcceleration = (float) $kickingAcceleration;
        return $this;
    }

    public function getKickingAcceleration()
    {
        return $this->kickingAcceleration;
    }

    public function setKickingDamping($kickingDamping)
    {
        $this->kickingDamping = (float) $kickingDamping;
        return $this;
    }

    public function getKickingDamping()
    {
        return $this->kickingDamping;
    }

    public function setKickingStrength($kickingStrength)
    {
        $this->kickingStrength = (float) $kickingStrength;
        return $this;
    }

    public function getKickingStrength()
    {
        return $this->kickingStrength;
    }

}
