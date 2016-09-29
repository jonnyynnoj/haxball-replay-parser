<?php

namespace ReplayParser;

use PhpBinaryReader\BinaryReader;

class Reader extends BinaryReader
{
    public function readDouble()
    {
        return unpack('d*', strrev($this->readBytes(8)))[1];
    }

    public function readStringAuto()
    {
        $len =  $this->readUInt16();
        return $len > 0 ? $this->readString($len) : '';
    }
}
