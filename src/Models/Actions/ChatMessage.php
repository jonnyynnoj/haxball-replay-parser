<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class ChatMessage extends Action
{
    private $msg;

    protected $type = 'chatMessage';

    public static function parse(Reader $reader)
    {
        return (new self)->setMsg($reader->readStringAuto());
    }

    protected function getData()
    {
        return ['msg' => $this->msg];
    }

    public function setMsg($msg)
    {
        $this->msg = (string) $msg;
        return $this;
    }

    public function getMsg()
    {
        return $this->msg;
    }
}
