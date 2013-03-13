<?php

require_once 'parser.php';
require_once 'map_parser.php';
require_once 'action.php';
require_once 'players.php';
require_once 'functions.php';

$roominfo = isset($_POST['roominfo']);
$showdiscs = isset($_POST['showdiscs']);
$showplayers = isset($_POST['showplayers']);
$showstads = isset($_POST['showstadiums']);
$showframes = isset($_POST['showactions']);
$showkicks = isset($_POST['showkicks']);

preg_match('~watch/(\w{8,10})~', $_POST['haxballtubelink'], $match);

if (!empty($match))
{
	$file = 'http://www.haxballtube.com/uploads/' . $match[1] . '.hbr';
}
else
{
	$file = $_FILES['replay']['tmp_name'];
}

$d = new parser(file_get_contents($file));

$version = $d->parseUint();
$HBRP = $d->parseStr(4);

$currentFrame = $d->parseUint();

if ($HBRP != 'HBRP')
{
	exit('Not a valid hbr file!');
}

if ($version < 7)
{
	exit('ERROR: Replay must be at least version 7.');
}

echo '<hr /><u>Replay Info</u><br />';
echo '<br />Replay Version: ', $version, '<br />';
echo 'Total Frames: ', $currentFrame, '<br />';
echo 'Replay Length: ', udate('i:s:u', $currentFrame / 60), '<br /><br />';

$d = new mapParser(gzuncompress($d->read()));

$firstframe = $d->parseUint();
$roomname = $d->parseStr();
$locked = $d->dumpBool();
$scorelimit = $d->parseByte();
$timelimit = $d->parseByte();
$rules = $d->parseUint();
$kotaken = $d->dumpBool();
$koteam = $d->dumpSide();
$puckx = $d->parseDouble();
$pucky = $d->parseDouble();
$redscore = $d->parseUint();
$bluescore = $d->parseUint();
$matchtimer = $d->parseDouble();

if ($version >= 9)
{
	$pausetimer = $d->parseByte();
}
elseif ($version >= 8)
{
	$pausetimer = $d->dumpBool();
}

$stadium = $d->dumpStadium();
$inProgress = $d->parseByte();

if ($roominfo)
{
	echo '<u>Room Info</u><br />';
	echo '<br />Room Name: ', $roomname;
	echo '<br />Teams Locked: ', $locked;
	echo '<br />Score Limit: ', $scorelimit;
	echo '<br />Time Limit: ', $timelimit;
	echo '<br />Rules Timer: ', $rules;
	echo '<br />KO Taken: ', $kotaken;
	echo '<br />KO Team: ', $koteam;
	echo '<br />Puck x: ', $puckx;
	echo '<br />Puck y: ', $pucky;
	echo '<br />Red Score: ', $redscore;
	echo '<br />Blue Score: ', $bluescore;
	echo '<br />Match Timer: ', secs2mins($matchtimer);
	echo '<br />Match in Progress: ', $inProgress ? 'true' : 'false';
	
	if ($version >= 8)
	{
		echo '<br />Paused: ', $pausetimer;
	}
	
	echo '<br />Stadium: ';
	
	if (!is_array($stadium))
	{
		echo $stadium;
	}
	else
	{
		echo '<textarea style="width: 600px; height: 500px">', json_format(json_encode($stadium)), '</textarea>';
	}
}

if (!$showdiscs && !$showplayers && !$showstads && !$showframes && !$showkicks)
{
	exit;
}

if ($inProgress)
{
	$discs = $d->parseUint();
	
	if ($showdiscs)
	{
		echo '<br /><br /><u>Dumping ', $discs, ' discs...</u>';
	}
	
	for ($i = 0; $i < $discs; ++$i)
	{
		$posx = $d->parseDouble();
		$posy = $d->parseDouble();
		$speedx = $d->parseDouble();
		$speedy = $d->parseDouble();
		$radius = $d->parseDouble();
		$bCoef = $d->parseDouble();
		$invMass = $d->parseDouble();
		$damping = $d->parseDouble();
		$colour = $d->dumpColor();
		$cMask = implode(', ', $d->parseMask());
		$cGroup = implode(', ', $d->parseMask());
		
		if ($showdiscs)
		{
			echo '<br /><br /><b>Disc ', $i, '</b>';
			echo '<br />Pos x: ', $posx;
			echo '<br />Pos y: ', $posy;
			echo '<br />Speed x: ', $speedx;
			echo '<br />Speed y: ', $speedy;
			echo '<br />Radius: ', $radius;
			echo '<br />bCoef: ', $bCoef;
			echo '<br />invMass: ', $invMass;
			echo '<br />Damping: ', $damping;
			echo '<br />Colour: ', $colour;
			echo '<br />cMask: ', $cMask;
			echo '<br />cGroup: ', $cGroup;
		}
	}
}

if (!$showplayers && !$showstads && !$showframes && !$showkicks)
{
	exit;
}
	
$playernum = $d->parseUint();
$Players = new Players;

if ($showplayers)
{
	echo '<br /><br /><u>Dumping ', $playernum, ' players...</u>';
}

for ($i = 0; $i < $playernum; ++$i)
{
	$id = $d->parseUint();
	$name = $d->parseStr();
	$admin = $d->dumpBool();
	$team = $d->dumpSide();
	$number = $d->parseByte();
	$avatar = $d->parseStr();
	$input = $d->parseInt();
	$autokick = $d->dumpBool();
	$desycned = $d->dumpBool();
	$country = $d->parseStr();
	
	if ($version >= 11)
	{
		$handicap = $d->parseUShort();
	}
	
	$discid = $d->parseUint();
	
	$Players->add($id, $name);
	
	if ($showplayers)
	{
		echo '<br /><br /><b>Player ', $i, '</b>';
		echo '<br />ID: ', $id;
		echo '<br />Name: ', $name;
		echo '<br />Admin: ', $admin;
		echo '<br />Team: ', $team;
		echo '<br />Number: ', $number;
		echo '<br />Avatar: ', $avatar;
		echo '<br />Input: ', $input;
		echo '<br />Kicking: ', $autokick;
		echo '<br />Desynced: ', $desycned;
		echo '<br />Country: ', $country;
		echo '<br />Disc ID: ', $discid;
		echo '<br />Handicap: ', $handicap;
	}
}

$action = new action($d->read(), $Players);
$kicks = array();
$prevkicks = array();
$replayTime = 0;
$theFrame = 0;
$shownTime = false;

if ($showstads || $showframes)
{
	echo '<br /><br /><u>Dumping frames...</u><br />';
}

$hasBeenPingUpdate = false;
$sincePingUpdate = 0;

while ($action->pos() < $action->size())
{
	if ($action->parseBool())
	{
		$theFrame += $action->parseUint();
		$replayTime = $theFrame / 60;
		$formatted = udate('i:s:u', $replayTime);
		
		$shownTime = false;
	}
	
	$sender = $Players->get($action->parseUint());
	
	$move = $action->dump();
	
	if ($move[0] === 'discMove')
	{
		if (strpos($move[1], 'kick') !== false && !$prevkicks[$sender]['kicking'])
		{
			if (!isset($prevkicks[$sender]))
			{
				$prevkicks[$sender] = array('lastkick' => $replayTime, 'kicking' => false);
			}
			
			$prevtime = $prevkicks[$sender]['lastkick'];
			
			$kicks[$sender][] = array(
				'time'	=> $formatted,
				'start'	=> $replayTime,
				'held'	=> 0,
				'diff'	=> round($replayTime - $prevtime, 5)
			);
			//$kicks[$sender][] = array($formatted, round($replayTime - $prevtime, 5));
			
			$prevkicks[$sender]['kicking'] = true;
		}
		elseif (strpos($move[1], 'kick') === false && $prevkicks[$sender]['kicking'])
		{
			$prevkicks[$sender] = array('lastkick' => $replayTime, 'kicking' => false);
			
			// set time held for
			$last = &$kicks[$sender][count($kicks[$sender]) - 1];
			$last['held'] = $replayTime - $last['start'];
			
			//$kicks[$sender][count($kicks[$sender]) - 1][] = $formatted;
		}
	}
	
	if ($showstads || $showframes)
	{
		if ($move[0] === 'changeStadium')
		{
			if (!$shownTime)
			{
				echo '<br /><b>', $formatted, '</b>';
				$shownTime = true;
			}
			
			echo '<br />Sender: ', $sender, '<br />';
			
			if (is_array($move[1]))
			{
				echo 'Loaded custom stadium: ', $move[1]['name'], '<br />';
				echo '<textarea style="width: 600px; height: 500px">', json_format(json_encode($move[1])), '</textarea>';
			}
			else
			{
				echo 'Loaded stadium: ', $move[1];
			}
			
			echo '<br />';
		}
		elseif ($showframes && $move[0] !== 'broadcastPing')
		{
			if (!$shownTime)
			{
				echo '<br /><b>', $formatted, '</b>';
				$shownTime = true;
			}
			
			echo '<br />Sender: ', $sender, '<br />';
			echo $move[1];
			echo '<br />';
		}
	}
}

if ($showkicks)
{
	// shortcuts
	echo '<br /><br />';
	
	foreach ($kicks as $player => $notneeded)
	{
		echo '<a href="#', $player, '">', $player, '</a><br />';
	}
	
	foreach ($kicks as $player => $pkicks)
	{
		echo '<br /><br /><u><a name="', $player, '">', $player, '</a> Kicks</u><br /><br />';
		
		echo '<table>';
			echo '<tr>';
				echo '<th>Started</th>';
				echo '<th>Ended</th>';
				echo '<th>Held for</th>';
				echo '<th>Time since last kick</th>';
			echo '</tr>';
			
			foreach ($pkicks as $k)
			{
				echo '<tr>';
					echo '<td>', $k['time'], '</td>';
					echo '<td>', udate('i:s:u', $k['start'] + $k['held']), '</td>';
					echo '<td>', round($k['held'], 5), '</td>';
					echo '<td>', $k['diff'], '</td>';
				echo '</tr>';
			}
		
		echo '</table>';
	}
}

?>