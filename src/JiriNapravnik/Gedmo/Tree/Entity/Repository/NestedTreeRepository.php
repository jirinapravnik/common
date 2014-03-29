<?php

/**
 * NestedTreeRepository
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2014, Jiří Nápravník
 */

namespace JiriNapravnik\Gedmo\Tree\Entity\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Gedmo\Tree\RepositoryUtils;

class NestedTreeRepository extends \Gedmo\Tree\Entity\Repository\NestedTreeRepository
{

//	private static $treeListener;

	public function __construct(EntityManager $em, ClassMetadata $class)
	{
//		$treeListener = self::$treeListener;

		$this->_entityName = $class->name;
		$this->_em = $em;
		$this->_class = $class;

//		if (is_null($treeListener)) {
//			throw new \Gedmo\Exception\InvalidMappingException('Tree listener was not found on your entity manager, it must be hooked into the event manager');
//		}
//
//		$this->listener = $treeListener;
//		if (!$this->validate()) {
//			throw new \Gedmo\Exception\InvalidMappingException('This repository cannot be used for tree type: ' . $treeListener->getStrategy($em, $class->name)->getName());
//		}
//
//		$this->repoUtils = new RepositoryUtils($this->_em, $this->getClassMetadata(), $this->listener, $this);
	}

	public function setTreeListener($treeListener)
	{
//		self::$treeListener = $treeListener;
		
		$this->listener = $treeListener;
		
		if (is_null($this->listener)) {
			throw new \Gedmo\Exception\InvalidMappingException('Tree listener was not found on your entity manager, it must be hooked into the event manager');
		}

		if (!$this->validate()) {
			throw new \Gedmo\Exception\InvalidMappingException('This repository cannot be used for tree type: ' . $this->getStrategy($em, $class->name)->getName());
		}

		$this->repoUtils = new RepositoryUtils($this->_em, $this->getClassMetadata(), $this->listener, $this);
	}

}
