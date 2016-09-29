<?php

namespace ReplayParser\Models\Stadium;

use ReplayParser\Reader;
use ReplayParser\Models\Stadium;

class Vertex extends MaskedItem implements \JsonSerializable
{
    private $x;
    private $y;
    private $bCoef;

    public static function parse(Reader $reader)
    {
        $vertex = new self;

        $vertex->setX($reader->readDouble())
            ->setY($reader->readDouble())
            ->setBCoef($reader->readDouble())
            ->setCMask(Stadium::parseMask($reader->readUInt32()))
            ->setCGroup(Stadium::parseMask($reader->readUInt32()));

        return $vertex;
    }

    public function jsonSerialize()
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
            'bCoef' => $this->bCoef,
            'cMask' => $this->cMask,
            'cGroup' => $this->cGroup
        ];
    }

    public function setX($x)
    {
        $this->x = $x;
        return $this;
    }

    public function getX()
    {
        return $this->x;
    }

    public function setY($y)
    {
        $this->y = $y;
        return $this;
    }

    public function getY()
    {
        return $this->y;
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
}
