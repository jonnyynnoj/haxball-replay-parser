<?php

namespace ReplayParser\Models;

use ReplayParser\Reader;

class TeamColor implements ParseableModelInterface
{
    /** @var int */
    private $angle;

    /** @var string */
    private $textColor;

    /** @var array */
    private $stripes = [];

    /**
     * @param  Reader $reader
     * @return TeamColor
     */
    public static function parse(Reader $reader)
    {
        $model = (new self)->setAngle($reader->readUint16())
            ->setTextColor(dechex($reader->readUint32()));

        $numStripes = $reader->readUint8();
        $stripes = [];

        for ($i = 0; $i < $numStripes; ++$i) {
            $stripes[] = dechex($reader->readUint32());
        }

        $model->setStripes($stripes);

        return $model;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'angle' => $this->angle,
            'textColor' => $this->textColor,
            'stripes' => $this->stripes
        ];
    }

    /**
     * @return int
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * @param  int angle
     * @return self
     */
    public function setAngle($angle)
    {
        $this->angle = $angle;
        return $this;
    }

    /**
     * @return string
     */
    public function getTextColor()
    {
        return $this->textColor;
    }

    /**
     * @param  string textColor
     * @return self
     */
    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;
        return $this;
    }

    /**
     * @return array
     */
    public function getStripes()
    {
        return $this->stripes;
    }

    /**
     * @param  array stripes
     * @return self
     */
    public function setStripes(array $stripes)
    {
        $this->stripes = $stripes;
        return $this;
    }

}
