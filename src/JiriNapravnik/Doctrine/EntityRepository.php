<?php

namespace JiriNapravnik\Doctrine;

use Kdyby\Doctrine\EntityRepository as KdybyEntityRepository;

class EntityRepository extends KdybyEntityRepository
{

	public function createNew()
	{
		$className = $this->getClassName();
		return new $className;
	}

}
