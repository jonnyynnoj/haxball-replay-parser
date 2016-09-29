<?php

namespace ReplayParser\Models\Actions;

use ReplayParser\Models\Action;
use ReplayParser\Reader;

class PlayerAvatarChange extends Action
{
    private $avatar;

    protected $type = 'playerAvatar';

    public static function parse(Reader $reader)
    {
        return (new self)->setAvatar($reader->readStringAuto());
    }

    protected function getData()
    {
        return ['avatar' => $this->avatar];
    }

    public function setAvatar($avatar)
    {
        $this->avatar = (string) $avatar;
        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }
}
