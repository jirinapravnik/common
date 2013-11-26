<?php

/**
 * Listener for page entity
 *
 * @author Jiří Nápravník (jirinapravnik.cz), Enbros.cz
 */

namespace JiriNapravnik\Doctrine\EntityListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

class SequenceListener
{

	/**
	 * @ORM\PrePersist 
	 */
	public function prePersist($item, LifecycleEventArgs $event)
	{
		$em = $event->getEntityManager();

		$qb = $em->createQueryBuilder();
		$maxSequence = $qb->select('MAX(i.sequence)')
			->from(get_class($item), 'i')
			->getQuery()
			->getOneOrNullResult();

		$sequenceNext = (int) $maxSequence[1] + 1;

		$item->setSequence($sequenceNext);
	}

	/**
	 * @ORM\PostRemove 
	 */
	public function postRemove($item, LifecycleEventArgs $event)
	{
		$em = $event->getEntityManager();

		$qb = $em->createQueryBuilder();
		$qb->update(get_class($item), 'i')
			->set('i.sequence', 'i.sequence - 1')
			->where('i.sequence > ' . $item->getSequence())
			->getQuery()
			->execute();
	}

	/**
	 * @ORM\PreUpdate
	 */
	public function preUpdate($item, PreUpdateEventArgs $event)
	{
		$oldSequence = $event->getOldValue('sequence');
		$newSequence = $event->getNewValue('sequence');

		if ($oldSequence === $newSequence) {
			return;
		}

		$em = $event->getEntityManager();

		$qb = $em->createQueryBuilder();
		$qb->update(get_class($item), 'i')
			->where('i.sequence = ' . $newSequence);

		if($newSequence > $oldSequence) {
			$qb->set('i.sequence', 'i.sequence - 1');
		} elseif($newSequence < $oldSequence) {
			$qb->set('i.sequence', 'i.sequence + 1');
		}

		$qb->getQuery()
			->execute();
	}

}
