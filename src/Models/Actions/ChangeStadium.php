<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Models\Stadium;
use ReplayParser\Reader;
use PhpBinaryReader\Endian;

class ChangeStadium extends Action
{
    private $stadium;

    protected $type = 'changeStadium';

    public static function parse(Reader $reader)
    {
        $len = $reader->readUInt32();
        $data = gzinflate($reader->readBytes($len));

        $reader = new Reader($data, Endian::ENDIAN_BIG);

        return (new self)->setStadium(Stadium::parse($reader));
    }

    protected function getData()
    {
        return ['stadium' => $this->stadium];
    }

    public function setStadium(Stadium $stadium)
    {
        $this->stadium = $stadium;
        return $this;
    }

    public function getStadium()
    {
        return $this->stadium;
    }
}
