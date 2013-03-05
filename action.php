<?php

class action extends mapParser
{
	public
		$action = 0,
		$actions = array();
	
	public function __construct($data, $Players)
	{
		parent::__construct($data);
		
		$this->Players = $Players;
		
		$this->actions = array(
			'newPlayer',
			'removePlayer',
			'playerChat',
			'logicUpdate',
			'startMatch',
			'stopMatch',
			'discMove',
			'changeTeam',
			'changeTeamsLock',
			'changeGameSettings',
			'changePlayerAvatar',
			'announceDesync',
			'changePlayerAdminRights',
			'changeStadium',
			'pauseGame',
			'broadcastPing',
			'announceHandicap'
		);
	}
	
	public function dump()
	{
		$k = $this->parseByte();
		
		return array($this->actions[$k], $this->{$this->actions[$k]}());
	}
	
	public function announceDesync()
	{
		return 'announce desync';
	}
	
	public function announceHandicap()
	{
		return '/handicap ' . $this->parseUShort();
	}
	
	public function broadcastPing()
	{
		$num = $this->parseByte();
		
		/*$strs = array();
		
		foreach ($this->Players->pList() as $id)
		{
			$strs[] = $this->Players->get($id) . ' ping is ' . $this->parseByte();
		}
		
		return implode('<br />', $strs);*/
		
		for ($i = 0; $i < $num; ++$i)
		{
			$this->parseByte();
		}
		
		return 'pings updated';
	}
	
	public function changeGameSettings()
	{
		$setting = $this->parseByte();
		$value = $this->parseUint();
		
		return 'setting ' . $setting . ' changed to ' . $value;
	}
	
	public function changePlayerAdminRights()
	{
		$player = $this->parseUint();
		$is_admin = $this->parseBool();
		
		if ($is_admin)
		{
			return 'made ' . $this->Players->get($player) . ' admin';
		}
		else
		{
			return 'removed admin from ' . $this->Players->get($player);
		}
	}
	
	public function changePlayerAvatar()
	{
		return '/avatar ' . $this->parseStr();
	}
	
	public function changeStadium()
	{
		$len = $this->parseUint();
		
		$stad = new mapParser(gzinflate($this->read($len)));
		return $stad->dumpStadium();
	}
	
	public function changeTeam()
	{
		$player = $this->parseUint();
		$team = $this->dumpSide();
		
		return $this->Players->get($player) . ' moved to ' . $team;
	}
	
	public function changeTeamsLock()
	{
		return 'teams ' . ($this->parseBool() ? 'locked' : 'unlocked');
	}
	
	public function discMove()
	{
		$moves = array(
			0 => 'no action',
			1 => 'move up',
			2 => 'move down',
			3 => 'move up down',
			4 => 'move left',
			5 => 'move up left',
			6 => 'move down left',
			7 => 'move up down left',
			8 => 'move right',
			9 => 'move up right',
			10 => 'move down right',
			11 => 'move up down right',
			12 => 'move left right',
			13 => 'move up left right',
			14 => 'move down left right',
			15 => 'move up down left right',
			16 => 'kick',
			17 => 'move up kick',
			18 => 'move down kick',
			19 => 'move up down kick',
			20 => 'move left kick',
			21 => 'move up left kick',
			22 => 'move down left kick',
			23 => 'move up down left kick',
			24 => 'move right kick',
			25 => 'move up right kick',
			26 => 'move down right kick',
			27 => 'move up down right kick',
			28 => 'move left right kick',
			29 => 'move up left right kick',
			30 => 'move down left right kick',
			31 => 'move up down left right kick'
		);
		
		$move = $this->parseByte();
		
		if ($move & 16 == 0)
		{
			return 'dunno';
		}
		
		return $moves[$move];
	}
	
	public function logicUpdate()
	{
		return 'logic update';
	}
	
	public function newPlayer()
	{
		$id = $this->parseUint();
		$name = $this->parseStr();
		$isAdmin = $this->dumpBool();
		$country = $this->parseStr();
		
		$this->Players->add($id, $name);
		
		return $name . ' joined';
	}
	
	public function pauseGame()
	{
		if ($this->parseBool())
		{
			return 'game paused';
		}
		else
		{
			return 'game unpaused';
		}
	}
	
	public function playerChat()
	{
		return '*' . $this->parseStr();
	}
	
	public function removePlayer()
	{
		$id = $this->parseUshort();
		$kicked = $this->parseBool();
		
		if ($kicked)
		{
			$kick_reason = $this->parseStr();
		}
		
		$ban = $this->parseBool();
		
		$player = $this->Players->get($id);
		$this->Players->remove($id);
		
		if ($kicked)
		{
			return '*' . $player . ' kicked: ' . $kick_reason;
		}
		elseif ($ban)
		{
			return '*' . $player . ' banned: ' . $kick_reason;
		}
		else
		{
			return '*' . $player . ' left';
		}
	}
	
	public function startMatch()
	{
		return 'start match';
	}
	
	public function stopMatch()
	{
		return 'stop match';
	}
}

?>