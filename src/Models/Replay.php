<?php

namespace ReplayParser\Models;

class Replay implements \JsonSerializable
{
    private $version;
    private $totalFrames;
    private $roomInfo;
    private $discs = [];
    private $players = [];
    private $teamColors = [];
    private $actions = [];

    public function jsonSerialize()
    {
        return [
            'version' => $this->version,
            'totalFrames' => $this->totalFrames,
            'length' => $this->getLength(),
            'roomInfo' => $this->roomInfo,
            'discs' => $this->discs,
            'players' => $this->players,
            'teamColors' => $this->teamColors,
            'actions' => $this->actions
        ];
    }

    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setTotalFrames($frames)
    {
        $this->totalFrames = (int) $frames;
        return $this;
    }

    public function getTotalFrames()
    {
        return $this->totalFrames;
    }

    public function getLength()
    {
        return $this->totalFrames / 60;
    }

    public function setRoomInfo(Room $info)
    {
        $this->roomInfo = $info;
        return $this;
    }

    public function getRoomInfo()
    {
        return $this->roomInfo;
    }

    public function setDiscs(array $discs)
    {
        $this->discs = $discs;
        return $this;
    }

    public function getDiscs()
    {
        return $this->discs;
    }

    public function setPlayers(array $players)
    {
        $this->players = $players;
        return $this;
    }

    public function getPlayers()
    {
        return $this->players;
    }

    public function setTeamColors(array $colors)
    {
        $this->teamColors = $colors;
        return $this;
    }

    public function getTeamColors()
    {
        return $this->teamColors;
    }

    public function setActions(array $actions)
    {
        $this->actions = $actions;
        return $this;
    }

    public function getActions()
    {
        return $this->actions;
    }
}
