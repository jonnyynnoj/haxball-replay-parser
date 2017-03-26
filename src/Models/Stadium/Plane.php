<?php

namespace ReplayParser\Models\Stadium;

use ReplayParser\Reader;
use ReplayParser\Models\Stadium;

class Plane extends MaskedItem
{
    private $normalX;
    private $normalY;
    private $dist;
    private $bCoef;

    public static function parse(Reader $reader)
    {
        $plane = new self;

        $plane->setNormalX($reader->readDouble())
            ->setNormalY($reader->readDouble())
            ->setDist($reader->readDouble())
            ->setBCoef($reader->readDouble())
            ->setCMask(Stadium::parseMask($reader->readUInt32()))
            ->setCGroup(Stadium::parseMask($reader->readUInt32()));

        return $plane;
    }

    public function jsonSerialize()
    {
        return [
            'normal' => [$this->normalX, $this->normalY],
            'dist' => $this->dist,
            'bCoef' => $this->bCoef,
            'cMask' => $this->cMask,
            'cGroup' => $this->cGroup
        ];
    }

    public function setNormalX($normalX)
    {
        $this->normalX = (float) $normalX;
        return $this;
    }

    public function getNormalX()
    {
        return $this->normalX;
    }

    public function setNormalY($normalY)
    {
        $this->normalY = (float) $normalY;
        return $this;
    }

    public function getNormalY()
    {
        return $this->normalY;
    }

    public function setDist($dist)
    {
        $this->dist = (float) $dist;
        return $this;
    }

    public function getDist()
    {
        return $this->dist;
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
}
