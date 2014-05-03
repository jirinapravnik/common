<?php

/**
 * DeleteCollisionResult
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2014, Jiří Nápravník
 */

namespace JiriNapravnik\Events;

class DeleteCollisionResult
{

	protected $entries = [];

	public function add($type, $collisions)
	{
		$this->entries[$type] = $collisions;
	}

	public function getEntries()
	{
		return $this->entries;
	}

	public function hasEntries()
	{
		return (count($this->entries) > 0) ? TRUE : FALSE;
	}

}
