<?php

class Players
{
	private $players = array();
	private $order = array();
	
	public function add($id, $name)
	{
		$this->players[$id] = $name;
		$this->order[] = $id;
	}
	
	public function get($id)
	{
		return $this->players[$id];
	}
	
	public function pList()
	{
		return $this->order;
	}
	
	public function remove($id)
	{
		unset($this->players[$id]);
		unset($this->order[array_search($id, $this->order)]);
	}
}

?>