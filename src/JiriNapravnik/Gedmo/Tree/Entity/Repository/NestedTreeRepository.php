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
	public function __construct(EntityManager $em, ClassMetadata $class)
	{

		$this->_entityName = $class->name;
		$this->_em = $em;
		$this->_class = $class;
	}

	public function setTreeListener($treeListener)
	{
		$this->listener = $treeListener;
		
		if (is_null($this->listener)) {
			throw new \Gedmo\Exception\InvalidMappingException('Tree listener was not found on your entity manager, it must be hooked into the event manager');
		}

		if (!$this->validate()) {
			throw new \Gedmo\Exception\InvalidMappingException('This repository cannot be used for tree type: ' . $this->getStrategy($this->_em, $this->_class->name)->getName());
		}
		
		$this->repoUtils = new RepositoryUtils($this->_em, $this->getClassMetadata(), $this->listener, $this);
	}

    public function createNew()
    {
        $className = $this->getClassName();
        return new $className;
    }
}
