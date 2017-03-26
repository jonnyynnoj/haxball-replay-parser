<?php

namespace ReplayParser\Models;

use ReplayParser\Reader;

class Room implements \JsonSerializable
{
    private $version;
    private $frame;
    private $name;
    private $locked;
    private $scoreLimit;
    private $timeLimit;
    private $rulesTimer;
    private $kickOffTaken;
    private $kickOffTeam;
    private $ballX;
    private $ballY;
    private $scoreRed;
    private $scoreBlue;
    private $matchTime;
    private $pauseTimer;
    private $stadium;
    private $inProgress;

    public function __construct($version)
    {
        $this->version = $version;
    }

    public static function parse(Reader $reader, $version)
    {
        $room = new self($version);

        $room->setFrame($reader->readUInt32())
            ->setName($reader->readStringAuto())
            ->setLocked($reader->readUint8())
            ->setScoreLimit($reader->readUint8())
            ->setTimeLimit($reader->readUint8())
            ->setRulesTimer($reader->readUInt32())
            ->setKickOffTaken($reader->readUint8())
            ->setKickOffTeam(Stadium::parseTeam($reader->readUint8()))
            ->setBallX($reader->readDouble())
            ->setBallY($reader->readDouble())
            ->setScoreRed($reader->readUInt32())
            ->setScoreBlue($reader->readUInt32())
            ->setMatchTime($reader->readDouble())
            ->setPauseTimer($reader->readUint8())
            ->setStadium(Stadium::parse($reader))
            ->setInProgress($reader->readUint8());

        // for custom maps there's an extra amount of data here
        // not sure what it does
        if ($room->getStadium()->isCustom()) {
            $reader->readBits(256);
        }

        return $room;
    }

    public function jsonSerialize()
    {
        return [
            'frame' => $this->frame,
            'name' => $this->name,
            'locked' => $this->locked,
            'scoreLimit' => $this->scoreLimit,
            'timeLimit' => $this->timeLimit,
            'rulesTimer' => $this->rulesTimer,
            'kickOffTaken' => $this->kickOffTaken,
            'kickOffTeam' => $this->kickOffTeam,
            'ball' => [
                'x' => $this->ballX,
                'y' => $this->ballY
            ],
            'score' => [
                'red' => $this->scoreRed,
                'blue' => $this->scoreBlue
            ],
            'matchTime' => $this->matchTime,
            'pauseTimer' => $this->pauseTimer,
            'stadium' => $this->stadium,
            'inProgess' => $this->inProgress
        ];
    }

    public function setFrame($frame)
    {
        $this->frame = (int) $frame;
        return $this;
    }

    public function getFrame()
    {
        return $this->frame;
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

    public function setLocked($status)
    {
        $this->locked = (bool) $status;
        return $this;
    }

    public function getLocked()
    {
        return $this->locked;
    }

    public function setScoreLimit($limit)
    {
        $this->scoreLimit = (int) $limit;
        return $this;
    }

    public function getScoreLimit()
    {
        return $this->scoreLimit;
    }

    public function setTimeLimit($limit)
    {
        $this->timeLimit = (int) $limit;
        return $this;
    }

    public function getTimeLimit()
    {
        return $this->timeLimit;
    }

    public function setRulesTimer($rulesTimer)
    {
        $this->rulesTimer = (int) $rulesTimer;
        return $this;
    }

    public function getRulesTimer()
    {
        return $this->rulesTimer;
    }

    public function setKickOffTaken($state)
    {
        $this->kickOffTaken = (bool) $state;
        return $this;
    }

    public function getKickOffTaken()
    {
        return $this->kickOffTaken;
    }

    public function setKickOffTeam($team)
    {
        $this->kickOffTeam = (string) $team;
        return $this;
    }

    public function getKickOffTeam()
    {
        return $this->kickOffTeam;
    }

    public function setBallX($pos)
    {
        $this->ballX = (float) $pos;
        return $this;
    }

    public function getBallX()
    {
        return $this->ballX;
    }

    public function setBallY($pos)
    {
        $this->ballY = (float) $pos;
        return $this;
    }

    public function getBallY()
    {
        return $this->ballY;
    }

    public function setScoreRed($score)
    {
        $this->scoreRed = (int) $score;
        return $this;
    }

    public function getScoreRed()
    {
        return $this->scoreRed;
    }

    public function setScoreBlue($score)
    {
        $this->scoreBlue = (int) $score;
        return $this;
    }

    public function getScoreBlue()
    {
        return $this->scoreBlue;
    }

    public function setMatchTime($timer)
    {
        $this->matchTime = (float) $timer;
        return $this;
    }

    public function getMatchTime()
    {
        return $this->matchTime;
    }

    public function setPauseTimer($timer)
    {
        $this->pauseTimer = $this->version == 8 ? (bool) $timer : (int) $timer;
        return $this;
    }

    public function getPauseTimer()
    {
        return $this->pauseTimer;
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

    public function setInProgress($state)
    {
        $this->inProgress = (bool) $state;
        return $this;
    }

    public function isPlaying()
    {
        return $this->inProgress;
    }
}
