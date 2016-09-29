<?php

namespace ReplayParser\Models;

use ReplayParser\Reader;

class Player implements \JsonSerializable
{
    private $version;

    private $id;
    private $name;
    private $admin;
    private $team;
    private $number;
    private $avatar;
    private $input;
    private $kicking;
    private $desynced;
    private $country;
    private $handicap;
    private $discId;

    public static function parse(Reader $reader, $version)
    {
        $player = new self($version);

        $player->setId($reader->readUInt32())
            ->setName($reader->readStringAuto())
            ->setAdmin($reader->readUInt8())
            ->setTeam($reader->readUInt8())
            ->setNumber($reader->readUInt8())
            ->setAvatar($reader->readStringAuto())
            ->setInput($reader->readUInt32())
            ->setKicking($reader->readUInt8())
            ->setDesynced($reader->readUInt8())
            ->setCountry($reader->readStringAuto());

        if ($version >= 11) {
            $player->setHandicap($reader->readUInt16());
        }

        $player->setDiscId($reader->readUInt32());

        return $player;
    }

    public function jsonSerialize()
    {
        $info = [
            'id' => $this->id,
            'name' => $this->name,
            'admin' => $this->admin,
            'team' => $this->team,
            'number' => $this->number,
            'avatar' => $this->avatar,
            'input' => $this->input,
            'kicking' => $this->kicking,
            'desynced' => $this->desynced,
            'country' => $this->country,
            'handicap' => $this->handicap,
            'discId' => $this->discId
        ];

        return $info;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAdmin($state)
    {
        $this->admin = (bool) $state;
        return $this;
    }

    public function isAdmin()
    {
        return $this->admin;
    }

    public function setTeam($team)
    {
        if (!in_array($team, Stadium::$teams)) {
            $team = Stadium::parseTeam($team);
        }

        $this->team = $team;
        return $this;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function setNumber($number)
    {
        $this->number = (int) $number;
        return $this;
    }

    public function getNumber()
    {
        return $this->number;
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

    public function setInput($input)
    {
        $this->input = (int) $input;
        return $this;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function setKicking($state)
    {
        $this->kicking = (bool) $state;
        return $this;
    }

    public function isKicking()
    {
        return $this->kicking;
    }

    public function setDesynced($state)
    {
        $this->desynced = (bool) $state;
        return $this;
    }

    public function isDesynced()
    {
        return $this->desynced;
    }

    public function setCountry($country)
    {
        $this->country = (string) $country;
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setHandicap($handicap)
    {
        $this->handicap = (int) $handicap;
        return $this;
    }

    public function getHandicap()
    {
        return $this->handicap;
    }

    public function setDiscId($discId)
    {
        $this->discId = (int) $discId;
        return $this;
    }

    public function getDiscId()
    {
        return $this->discId;
    }
}
