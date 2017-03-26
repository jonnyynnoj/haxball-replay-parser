<?php

namespace ReplayParser\Models\Stadium;

use ReplayParser\Reader;
use ReplayParser\Models\Stadium;

class Segment extends MaskedItem
{
    private $v0;
    private $v1;
    private $bCoef;
    private $curve;
    private $vis;
    private $color;

    public static function parse(Reader $reader)
    {
        $segment = new self;

        $segment->setV0($reader->readUInt8())
            ->setV1($reader->readUInt8())
            ->setBCoef($reader->readDouble())
            ->setCMask(Stadium::parseMask($reader->readUInt32()))
            ->setCGroup(Stadium::parseMask($reader->readUInt32()))
            ->setCurve($reader->readDouble())
            ->setVis($reader->readUInt8())
            ->setColor(dechex($reader->readUInt32()));

        return $segment;
    }

    public function jsonSerialize()
    {
        return [
            'v0' => $this->v0,
            'v1' => $this->v1,
            'bCoef' => $this->bCoef,
            'cMask' => $this->cMask,
            'cGroup' => $this->cGroup,
            'curve' => $this->curve,
            'vis' => $this->vis,
            'color' => $this->color
        ];
    }

    public function setV0($v0)
    {
        $this->v0 = (float) $v0;

        return $this;
    }

    public function getV0()
    {
        return $this->v0;
    }

    public function setV1($v1)
    {
        $this->v1 = (float) $v1;
        return $this;
    }

    public function getV1()
    {
        return $this->v1;
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

    public function setCurve($curve)
    {
        if (is_nan($curve)) {
            $curve = 0;
        }

        $this->curve = (float) $curve;
        return $this;
    }

    public function getCurve()
    {
        return $this->curve;
    }

    public function setVis($vis)
    {
        $this->vis = (bool) $vis;
        return $this;
    }

    public function getVis()
    {
        return $this->vis;
    }

    public function setColor($color)
    {
        $this->color = (string) $color;
        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }
}
