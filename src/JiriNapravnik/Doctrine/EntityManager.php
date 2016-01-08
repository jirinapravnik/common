<?php

namespace JiriNapravnik\Doctrine;

use Doctrine;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMException;
use InvalidArgumentException;

class EntityManager extends \Kdyby\Doctrine\EntityManager
{

	/**
	 * Factory method to create EntityManager instances.
	 *
	 * @param \Doctrine\DBAL\Connection|array $conn
	 * @param \Doctrine\ORM\Configuration $config
	 * @param \Doctrine\Common\EventManager $eventManager
	 * @throws \Doctrine\ORM\ORMException
	 * @throws InvalidArgumentException
	 * @throws \Doctrine\ORM\ORMException
	 * @return EntityManager
	 */
	public static function create($conn, Doctrine\ORM\Configuration $config, Doctrine\Common\EventManager $eventManager = NULL)
	{
		if (!$config->getMetadataDriverImpl()) {
			throw ORMException::missingMappingDriverImpl();
		}

		switch (TRUE) {
			case (is_array($conn)):
				$conn = DriverManager::getConnection(
					$conn, $config, ($eventManager ? : new Doctrine\Common\EventManager())
				);
				break;

			case ($conn instanceof Doctrine\DBAL\Connection):
				if ($eventManager !== NULL && $conn->getEventManager() !== $eventManager) {
					throw ORMException::mismatchedEventManager();
				}
				break;

			default:
				throw new InvalidArgumentException("Invalid connection");
		}

		return new EntityManager($conn, $config, $conn->getEventManager());
	}
	
	public function onDaoCreate(\Kdyby\Doctrine\EntityManager $em, \Doctrine\Common\Persistence\ObjectRepository $dao)
	{
		return;
	}

}
