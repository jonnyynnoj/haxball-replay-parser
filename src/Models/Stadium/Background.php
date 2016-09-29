<?php

namespace ReplayParser\Models\Stadium;

use ReplayParser\Reader;

class Background implements \JsonSerializable
{
    private $type;
    private $width;
    private $height;
    private $kickOffRadius;
    private $cornerRadius;
    private $goalLine;
    private $color;

    public static function parse(Reader $reader)
    {
        $background = new self;

        $type = $reader->readUint8();

        $background->setType($type == 2 ? 'hockey' : ($type == 1 ? 'grass' : 'none'))
            ->setWidth($reader->readDouble())
            ->setHeight($reader->readDouble())
            ->setKickOffRadius($reader->readDouble())
            ->setCornerRadius($reader->readDouble())
            ->setGoalLine($reader->readDouble())
            ->setColor(dechex($reader->readUint32()));

        return $background;
    }

    public function jsonSerialize()
    {
        return [
            'type' => $this->type,
            'width' => $this->width,
            'height' => $this->height,
            'kickOffRadius' => $this->kickOffRadius,
            'cornerRadius' => $this->cornerRadius,
            'goalLine' => $this->goalLine,
            'color' => $this->color
        ];
    }

    public function setType($type)
    {
        $this->type = (string) $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setWidth($width)
    {
        $this->width = (float) $width;
        return $this;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setHeight($height)
    {
        $this->height = (float) $height;
        return $this;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setKickOffRadius($kickOffRadius)
    {
        $this->kickOffRadius = (float) $kickOffRadius;
        return $this;
    }

    public function getKickOffRadius()
    {
        return $this->kickOffRadius;
    }

    public function setCornerRadius($cornerRadius)
    {
        $this->cornerRadius = (float) $cornerRadius;
        return $this;
    }

    public function getCornerRadius()
    {
        return $this->cornerRadius;
    }

    public function setGoalLine($goalLine)
    {
        if (is_nan($goalLine)) {
            $goalLine = 0;
        }

        $this->goalLine = (float) $goalLine;
        return $this;
    }

    public function getGoalLine()
    {
        return $this->goalLine;
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
