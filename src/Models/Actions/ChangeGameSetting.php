<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class ChangeGameSetting extends Action
{
    private $setting;
    private $value;

    protected $type = 'changeGameSetting';

    public static function parse(Reader $reader)
    {
        $action = (new self)->setSetting($reader->readUint8())
            ->setValue($reader->readUInt32());

        return $action;
    }

    protected function getData()
    {
        return [
            'setting' => $this->setting,
            'value' => $this->value
        ];
    }

    public function setSetting($setting)
    {
        $this->setting = (int) $setting;
        return $this;
    }

    public function getSetting()
    {
        return $this->setting;
    }

    public function setValue($value)
    {
        $this->value = (int) $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }
}
