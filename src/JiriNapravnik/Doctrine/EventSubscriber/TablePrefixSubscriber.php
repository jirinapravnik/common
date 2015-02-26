<?php

namespace JiriNapravnik\Doctrine\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

/**
 * dcotrine event for table prefix
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class TablePrefixSubscriber implements EventSubscriber
{

	protected $prefix = '';

	public function __construct($prefix)
	{
		$this->prefix = (string) $prefix;
	}

	public function getSubscribedEvents()
	{
		return array(Events::loadClassMetadata);
	}

	public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
	{
		$classMetadata = $eventArgs->getClassMetadata();
		$classMetadata->setTableName($this->prefix . $classMetadata->getTableName());
		foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
			if ($mapping['type'] == ClassMetadataInfo::MANY_TO_MANY && isset($classMetadata->associationMappings[$fieldName]['joinTable']['name'])) {
				$mappedTableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
				
				// Do not re-apply the prefix when the association is already prefixed
				if (false !== strpos($mappedTableName, $this->prefix)) {
					continue;
				}
				
				$classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $mappedTableName;
			}
		}
	}

}
