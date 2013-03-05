<?php

class parser
{
	private
		$data		= '',
		$pointer	= 0;
	
	public function __construct($data)
	{
		$this->data = $data;
	}
	
	public function pos()
	{
		return $this->pointer;
	}
	
	public function size()
	{
		return mb_strlen($this->data);
	}
	
	public function read($len = 0)
	{
		if ($len == 0)
		{
			$len = $this->size();
		}
		
		$string = mb_substr($this->data, $this->pointer, $len);
		
		$this->pointer += $len;
		
		return $string;
	}
	
	public function field($type, $len, $chrs = false, $implode = true)
	{
		$data = unpack($type, $this->read($len));
		
		if ($chrs)
		{
			$data = array_map('chr', $data);
		}
		
		return $implode ? implode('', $data) : $data;
	}
	
	/* Parser functions */
	
	public function parseStr($len = 0)
	{
		if ($len == 0)
		{
			$len = $this->parseUshort();
			
			if ($len == 0)
			{
				return;
			}
		}
		
		return $this->field('c*', $len, true);
	}
	
	public function parseBool()
	{
		return (bool) $this->parseByte();
	}
	
	public function parseByte()
	{
		return $this->field('C*', 1);
	}
	
	public function parseBytes($len)
	{
		return $this->field('l*', $len);
	}
	
	public function parseDouble()
	{
		$data = unpack('d*', strrev($this->read(8)));
		
		return implode('', $data);
	}
	
	public function parseFloat()
	{
		$data = unpack('f*', strrev($this->read(4)));
		
		return implode('', $data);
	}
	
	public function parseInt()
	{
		return $this->field('l*', 4);
	}
	
	public function parseShort()
	{
		return $this->field('s*', 2);
	}
	
	public function parseUint()
	{
		return $this->field('N*', 4);
	}
	
	public function parseUshort()
	{
		return $this->field('n*', 2);
	}
	
	/* Dumper functions */
	
	public function dumpBool()
	{
		return $this->parseByte() ? 'true' : 'false';
	}
	
	public function dumpColor()
	{
		return dechex($this->parseUint());
	}
}

?>