<?php

namespace JiriNapravnik\Gedmo\Tree;

use Gedmo\Tree\TreeListener as GedmoTreeListener;
use Kdyby\Doctrine\Events;

/**
 * GedmoTreeListener
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class TreeListener extends GedmoTreeListener
{
	public function getSubscribedEvents(){
		$events = parent::getSubscribedEvents();
		
		unset($events[array_search('loadClassMetadata', $events)]);
		$events[] = Events::loadClassMetadata;
		
		return $events;
	}
}
