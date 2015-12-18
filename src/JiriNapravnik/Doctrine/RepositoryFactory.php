<?php

namespace JiriNapravnik\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use JiriNapravnik\Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use JiriNapravnik\Gedmo\Tree\TreeListener;
use Kdyby\Doctrine\RepositoryFactory as KdybyRepositoryFactory;
use Nette\DI\Container;

class RepositoryFactory extends KdybyRepositoryFactory
{
	private $serviceLocator;
	
	public function __construct(Container $serviceLocator)
	{
		parent::__construct($serviceLocator);
		$this->serviceLocator = $serviceLocator;
	}
	
	public function getRepository(EntityManagerInterface $entityManager, $entityName)
	{
		$repository = parent::getRepository($entityManager, $entityName);
		if($repository instanceof NestedTreeRepository){
			$repository->setTreeListener($this->serviceLocator->getByType(TreeListener::class));
		}
		
		return $repository;
	}

}
