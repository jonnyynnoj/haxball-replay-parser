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
    private $kickStrength;

    private $defaults = [
        'bCoef' => 0.5,
        'invMass' => 0.5,
        'damping' => 0.96,
        'acceleration' => 0.1,
        'kickingAcceleration' => 0.07,
        'kickingDamping' => 0.96,
        'kickStrength' => 5
    ];

    public static function parse(Reader $reader)
    {
        $physics = new self;

        $physics->setBCoef($reader->readDouble())
            ->setInvMass($reader->readDouble())
            ->setDamping($reader->readDouble())
            ->setAcceleration($reader->readDouble())
            ->setKickingAcceleration($reader->readDouble())
            ->setKickingDamping($reader->readDouble())
            ->setKickStrength($reader->readDouble());

        return $physics;
    }

    public function jsonSerialize()
    {
        $data = [];

        foreach ($this->defaults as $prop => $default) {
            if ($this->$prop != $this->defaults[$prop]) {
                $data[$prop] = $this->$prop;
            }
        }

        return $data;
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

    public function setKickStrength($kickStrength)
    {
        $this->kickStrength = (float) $kickStrength;
        return $this;
    }

    public function getKickStrength()
    {
        return $this->kickStrength;
    }
}
