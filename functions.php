<?php

function udate($format, $utimestamp = null)
{
	if (is_null($utimestamp))
	{
		$utimestamp = microtime(true);
	}
	
	$timestamp = floor($utimestamp);
	$milliseconds = round(($utimestamp - $timestamp) * 1000000);
	
	// Fix for leading 0 disappearing
	if (strpos('.', $utimestamp) === false || substr($utimestamp, strpos($utimestamp, '.') + 1, 1) == 0)
	{
		$milliseconds = str_repeat('0', 6 - strlen($milliseconds)) . $milliseconds;
	}
	
	return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
}

function secs2mins($secs)
{
	$mins = floor($secs / 60);
	$secs_left = $secs % 60;
	
	if ($mins < 10)
	{
		$mins = '0' . $mins;
	}
	
	if ($secs_left < 10)
	{
		$secs_left = '0' . $secs_left;
	}
	
	return $mins . ':' . $secs_left;
}

// Pretty print some JSON 
function json_format($json) 
{ 
	$tab = "  "; 
	$new_json = ""; 
	$indent_level = 0; 
	$in_string = false; 

	$json_obj = json_decode($json); 

	if($json_obj === false) 
		return false; 

	$json = json_encode($json_obj); 
	$len = strlen($json); 

	for($c = 0; $c < $len; $c++) 
	{ 
		$char = $json[$c]; 
		switch($char) 
		{ 
			case '{': 
			case '[': 
				if(!$in_string) 
				{ 
					$new_json .= $char . "\n" . str_repeat($tab, $indent_level+1); 
					$indent_level++; 
				} 
				else 
				{ 
					$new_json .= $char; 
				} 
				break; 
			case '}': 
			case ']': 
				if(!$in_string) 
				{ 
					$indent_level--; 
					$new_json .= "\n" . str_repeat($tab, $indent_level) . $char; 
				} 
				else 
				{ 
					$new_json .= $char; 
				} 
				break; 
			case ',': 
				if(!$in_string) 
				{ 
					$new_json .= ",\n" . str_repeat($tab, $indent_level); 
				} 
				else 
				{ 
					$new_json .= $char; 
				} 
				break; 
			case ':': 
				if(!$in_string) 
				{ 
					$new_json .= ": "; 
				} 
				else 
				{ 
					$new_json .= $char; 
				} 
				break; 
			case '"': 
				if($c > 0 && $json[$c-1] != '\\') 
				{ 
					$in_string = !$in_string; 
				} 
			default: 
				$new_json .= $char; 
				break;                    
		} 
	} 

	return $new_json; 
}

?>