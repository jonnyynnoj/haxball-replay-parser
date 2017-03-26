<?php

namespace ReplayParser\Models\Stadium;

use ReplayParser\Reader;
use ReplayParser\Models\Stadium;

class Disc extends MaskedItem
{
    private $posX;
    private $posY;
    private $velocityX;
    private $velocityY;
    private $radius;
    private $bCoef;
    private $invMass;
    private $damping;
    private $color;

    public static function parse(Reader $reader)
    {
        $disc = new self;

        $disc->setPosX($reader->readDouble())
            ->setPosY($reader->readDouble())
            ->setVelocityX($reader->readDouble())
            ->setVelocityY($reader->readDouble())
            ->setRadius($reader->readDouble())
            ->setBCoef($reader->readDouble())
            ->setInvMass($reader->readDouble())
            ->setDamping($reader->readDouble())
            ->setColor(dechex($reader->readUInt32()))
            ->setCMask(Stadium::parseMask($reader->readUInt32()))
            ->setCGroup(Stadium::parseMask($reader->readUInt32()));

        return $disc;
    }

    public function jsonSerialize()
    {
        return [
            'pos' => [
                'x' => $this->posX,
                'y' => $this->posY
            ],
            'velocity' => [
                'x' => $this->velocityX,
                'y' => $this->velocityY
            ],
            'radius' => $this->radius,
            'bCeof' => $this->bCoef,
            'invMass' => $this->invMass,
            'damping' => $this->damping,
            'color' => $this->color,
            'collisionMask' => $this->cMask,
            'collisionGroup' => $this->cGroup
        ];
    }

    public function setPosX($pos)
    {
        $this->posX = (float) $pos;
        return $this;
    }

    public function getPosX()
    {
        return $this->posX;
    }

    public function setPosY($pos)
    {
        $this->posY = (float) $pos;
        return $this;
    }

    public function getPosY()
    {
        return $this->posY;
    }

    public function setVelocityX($pos)
    {
        $this->velocityX = (float) $pos;
        return $this;
    }

    public function getVelocityX()
    {
        return $this->velocityX;
    }

    public function setVelocityY($pos)
    {
        $this->velocityY = (float) $pos;
        return $this;
    }

    public function getVelocityY()
    {
        return $this->velocityY;
    }

    public function setRadius($radius)
    {
        $this->radius = (float) $radius;
        return $this;
    }

    public function getRadius()
    {
        return $this->radius;
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
