<?php

namespace ReplayParser;

use ReplayParser\Models\Player;
use ReplayParser\Models\Replay;
use ReplayParser\Models\Room;
use ReplayParser\Models\TeamColor;
use ReplayParser\Models\Actions\BroadcastPings;
use ReplayParser\Models\Actions\ChangeColors;
use ReplayParser\Models\Actions\ChangeGameSetting;
use ReplayParser\Models\Actions\ChangePaused;
use ReplayParser\Models\Actions\ChangeStadium;
use ReplayParser\Models\Actions\ChangeTeamsLock;
use ReplayParser\Models\Actions\ChatMessage;
use ReplayParser\Models\Actions\Desynced;
use ReplayParser\Models\Actions\DiscMove;
use ReplayParser\Models\Actions\LogicUpdate;
use ReplayParser\Models\Actions\MatchStart;
use ReplayParser\Models\Actions\MatchStopped;
use ReplayParser\Models\Actions\PlayerAdminChange;
use ReplayParser\Models\Actions\PlayerAvatarChange;
use ReplayParser\Models\Actions\PlayerHandicapChange;
use ReplayParser\Models\Actions\PlayerJoined;
use ReplayParser\Models\Actions\PlayerLeft;
use ReplayParser\Models\Actions\PlayerTeamChange;
use ReplayParser\Models\Stadium\Disc;
use PhpBinaryReader\Endian;
use InvalidArgumentException;

class Parser
{
    private $replay;

    private static $actionTypes = [
        PlayerJoined::class,
        PlayerLeft::class,
        ChatMessage::class,
        LogicUpdate::class,
        MatchStart::class,
        MatchStopped::class,
        DiscMove::class,
        PlayerTeamChange::class,
        ChangeTeamsLock::class,
		ChangeGameSetting::class,
		PlayerAvatarChange::class,
		Desynced::class,
		PlayerAdminChange::class,
		ChangeStadium::class,
		ChangePaused::class,
		BroadcastPings::class,
		PlayerHandicapChange::class,
        ChangeColors::class
    ];

    public function  __construct($replayData)
    {
        $this->reader = new Reader($replayData, Endian::ENDIAN_BIG);

        $version = $this->reader->readUInt32();
        $hbrpCheck = $this->reader->readString(4);
        $frames = $this->reader->readUInt32();

        if ($hbrpCheck !== 'HBRP') {
            throw new InvalidArgumentException('Not a valid haxball replay!');
        }

        if ($version < 7) {
            throw new InvalidArgumentException('Replay must be at least version 7');
        }

        $this->replay = new Replay;

        $this->replay->setVersion($version)
            ->setTotalFrames($frames);
    }

    public function parse()
    {
        $data = gzuncompress($this->reader->getInputString());
        $reader = new Reader($data, Endian::ENDIAN_BIG);

        $room = $this->parseRoomInfo($reader);
        $this->replay->setRoomInfo($room);

        if ($room->isPlaying()) {
            $this->replay->setDiscs($this->parseDiscs($reader));
        }

        $this->replay->setPlayers($this->parsePlayers($reader));

        if ($this->replay->getVersion() >= 12) {
            $this->replay->setTeamColors($this->parseTeamColors($reader));
        }

        $this->replay->setActions($this->parseActions($reader));

        return $this->replay;
    }

    private function parseRoomInfo(Reader $reader)
    {
        return Room::parse($reader, $this->replay->getVersion());
    }

    private function parseDiscs(Reader $reader)
    {
        $discs = [];
        $num = $reader->readUInt32();

        var_dump($num);exit;

        for ($i = 0; $i < $num; ++$i) {
            $discs[] = Disc::parse($reader);
        }

        return $discs;
    }

    private function parsePlayers(Reader $reader)
    {
        $players = [];
        $num = $reader->readUInt32();

        for ($i = 0; $i < $num; ++$i) {
            $players[] = Player::parse($reader, $this->replay->getVersion());
        }

        return $players;
    }

    private function parseTeamColors(Reader $reader)
    {
        return [
            'red' => TeamColor::parse($reader),
            'blue' => TeamColor::parse($reader)
        ];
    }

    private function parseActions(Reader $reader)
    {
        $actions = [];
        $frame = 0;
        $count = 0;

        while (!$reader->isEof()) {
            $newFrame = $reader->readUint8();

            if ($newFrame) {
                $frame += $reader->readUInt32();
            }

            $sender = $reader->readUInt32();
            $type = $reader->readUint8();

            if (!isset(self::$actionTypes[$type])) {
                throw new InvalidArgumentException('Action type ' . $type . ' invalid');
            }

            $class = self::$actionTypes[$type];

            $action = $class::parse($reader)
                ->setFrame($frame)
                ->setSender($sender);

            $actions[] = $action;
        }

        return $actions;
    }


}
