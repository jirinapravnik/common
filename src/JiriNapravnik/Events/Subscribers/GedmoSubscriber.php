<?php

/**
 * GedmoSubscriber
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2014, Jiří Nápravník
 */

namespace JiriNapravnik\Events\Subscribers;

use Kdyby\Events\Subscriber;
use Nette\Object;

class GedmoSubscriber extends Object implements Subscriber
{

	private $container;

	public function __construct(\Nette\DI\Container $container)
	{
		$this->container = $container;
	}

	public function getSubscribedEvents()
	{
		return array(
			'Kdyby\Doctrine\EntityManager::onDaoCreate',
		);
	}

	public function onDaoCreate($em, $dao)
	{
		if($dao instanceof \JiriNapravnik\Gedmo\Tree\Entity\Repository\NestedTreeRepository){
			$dao->setTreeListener($this->container->getByType('Gedmo\Tree\TreeListener'));
		}
	}
}
