<?php

namespace ReplayParser;

use PhpBinaryReader\BinaryReader;

class Reader extends BinaryReader
{
    public function readDouble()
    {
        $double = unpack('d*', strrev($this->readBytes(8)))[1];
        return is_nan($double) ? 0 : $double;
    }

    public function readStringAuto()
    {
        $len =  $this->readUInt16();
        return $len > 0 ? $this->readString($len) : '';
    }
}
