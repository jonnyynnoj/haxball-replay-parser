<?php

class mapParser extends parser
{
	public function dumpSide()
	{
		switch ($this->parseByte())
		{
			case 1:
				return 'Red';
				break;
			case 2:
				return 'Blue';
				break;
			case 0:
				return 'Spectator';
				break;
		}
	}
	
	public function dumpStadium()
	{
		$fields = array(
			0 => 'Classic',
			1 => 'Easy',
			2 => 'Small',
			3 => 'Big',
			4 => 'Rounded',
			5 => 'Hockey',
			6 => 'Big Hockey',
			7 => 'Big Easy',
			8 => 'Big Rounded',
			9 => 'Huge'
		);
		
		$s = $this->parseByte();
		
		if ($s == 255)
		//if (!isset($fields[$s]))
		{
			return $this->parseCustomMap();
		}
		else
		{
			return $fields[$s];
		}
	}
	
	public function parseCustomMap()
	{
		$name = $this->parseStr();
		$bgType = $this->parseByte();
		$bgWidth = $this->parseDouble();
		$bgHeight = $this->parseDouble();
		$bgKickoffRadius = $this->parseDouble();
		$bgCornerRadius = $this->parseDouble();
		$bgGoalLine = $this->parseDouble();
		$bgColor = $this->dumpColor();
		$cameraWidth = $this->parseDouble();
		$cameraHeight = $this->parseDouble();
		$spawnDistance = $this->parseDouble();
		
		$map = array(
			'name'			=> $name,
			'width'			=> $cameraWidth,
			'height'		=> $cameraHeight,
			'spawnDistance'	=> $spawnDistance,
			
			'bg' => array(
				'type'			=> $bgType == 2 ? 'hockey' : ($bgType == 1 ? 'grass' : 'none'),
				'width'			=> $bgWidth,
				'height'		=> $bgHeight,
				'kickOffRadius'	=> $bgKickoffRadius,
				'cornerRadius'	=> $bgCornerRadius,
				'goalLine'		=> $bgGoalLine == 'NAN' ? '' : $bgGoalLine,
				'color'			=> $bgColor
			),
			
			'playerPhysics'	=> array(),
			'ballPhysics'	=> array(),
			
			'vertexes'	=> array(),
			'segments'	=> array(),
			'planes'	=> array(),
			'goals'		=> array()
		);
		
		// vertices
		$num = $this->parseByte();
		
		for ($i = 0; $i < $num; ++$i)
		{
			 $map['vertexes'][] = array(
				'x'			=> $this->parseDouble(),
				'y'			=> $this->parseDouble(),
				'bCoef'		=> sprintf('%f', $this->parseDouble()),
				'cMask'		=> $this->parseMask(),
				'cGroup'	=> $this->parseMask()
			);
		}
		
		// segments
		$num = $this->parseByte();
		
		for ($i = 0; $i < $num; ++$i)
		{
			$segment = array(
				'v0'		=> (int) $this->parseByte(),
				'v1'		=> (int) $this->parseByte(),
				'bCoef'		=> sprintf('%f', $this->parseDouble()),
				'cMask'		=> $this->parseMask(),
				'cGroup'	=> $this->parseMask(),
				'curve'		=> sprintf('%f', $this->parseDouble()),
				'vis'		=> $this->parseBool(),
				'color'		=> $this->dumpColor()
			);
			
			if ($segment['curve'] == 'NAN')
			{
				$segment['curve'] = 0;
			}
			
			$map['segments'][] = $segment;
		}
		
		// planes
		$num = $this->parseByte();
		
		for ($i = 0; $i < $num; ++$i)
		{
			$map['planes'][] = array(
				'normal' => array(
					$this->parseDouble(),
					$this->parseDouble()
				),
				'dist'		=> $this->parseDouble(),
				'bCoef'		=> sprintf('%f', $this->parseDouble()),
				'cMask'		=> $this->parseMask(),
				'cGroup'	=> $this->parseMask()
			);
		}
		
		// goals
		$num = $this->parseByte();
		
		for ($i = 0; $i < $num; ++$i)
		{
			$map['goals'][] = array(
				'p0' => array(
					$this->parseDouble(),
					$this->parseDouble()
				),
				'p1' => array(
					$this->parseDouble(),
					$this->parseDouble()
				),
				'team' => $this->parseBool() ? 'red' : 'blue'
			);
		}
		
		// discs
		$num = $this->parseByte();
		
		for ($i = 0; $i < $num; ++$i)
		{
			$map['discs'][] = array(
				'pos' => array(
					$this->parseDouble(),
					$this->parseDouble()
				),
				'speed' => array(
					$this->parseDouble(),
					$this->parseDouble()
				),
				'radius'	=> $this->parseDouble(),
				'bCoef'		=> sprintf('%f', $this->parseDouble()),
				'invMass'	=> sprintf('%f', $this->parseDouble()),
				'damping'	=> sprintf('%f', $this->parseDouble()),
				'color'		=> $this->dumpColor(),
				'cMask'		=> $this->parseMask(),
				'cGroup'	=> $this->parseMask()
			);
		}
		
		// player physics
		$map['playerPhysics'] = array(
			'bCoef'					=> sprintf('%f', $this->parseDouble()),
			'invMass'				=> sprintf('%f', $this->parseDouble()),
			'damping'				=> sprintf('%f', $this->parseDouble()),
			'acceleration'			=> sprintf('%f', $this->parseDouble()),
			'kickingAcceleration'	=> sprintf('%f', $this->parseDouble()),
			'kickingDamping'		=> sprintf('%f', $this->parseDouble()),
			'kickStrength'			=> sprintf('%f', $this->parseDouble())
		);
		
		// pos attrs - not used
		$this->parseDouble();
		$this->parseDouble();
		$this->parseDouble();
		$this->parseDouble();
		
		$radius		= $this->parseDouble();
		$bCoef		= $this->parseDouble();
		$invMass	= $this->parseDouble();
		$damping	= $this->parseDouble();
		$color		= $this->dumpColor();
		$cMask		= $this->parseMask();
		$cGroup		= $this->parseMask();
		
		if ($radius > 0)
		{
			$map['ballPhysics']['radius'] = $radius;
		}
		
		if ($bCoef > 0)
		{
			$map['ballPhysics']['bCoef'] = $bCoef;
		}
		
		if ($invMass > 0)
		{
			$map['ballPhysics']['invMass'] = $invMass;
		}
		
		if ($damping > 0)
		{
			$map['ballPhysics']['damping'] = $damping;
		}
		
		if ($color != '')
		{
			$map['ballPhysics']['color'] = $color;
		}
		
		if (!empty($cMask))
		{
			$map['ballPhysics']['cMask'] = $cMask;
		}
		
		if (!empty($cGroup))
		{
			$map['ballPhysics']['cGroup'] = $cGroup;
		}
		
		return $map;
	}
	
	public function parseMask()
	{
		$int = $this->parseUint();
		$mask = array();
		
		if ($int == -1 || $int == 4294967295)
		{
			return array('all');
		}
		else
		{
			while ($int > 0)
			{
				if ($int & 32)
				{
					$mask[] = 'wall';
					$int &= ~32;
				}
				elseif ($int & 16)
				{
					$mask[] = 'blueKO';
					$int &= ~16;
				}
				elseif ($int & 8)
				{
					$mask[] = 'redKO';
					$int &= ~8;
				}
				elseif ($int & 4)
				{
					$mask[] = 'blue';
					$int &= ~4;
				}
				elseif ($int & 2)
				{
					$mask[] = 'red';
					$int &= ~2;
				}
				elseif ($int & 1)
				{
					$mask[] = 'ball';
					$int &= ~1;
				}
			}
			
			return $mask;
		}
	}
}

?>