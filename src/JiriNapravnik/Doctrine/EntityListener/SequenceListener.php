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
	 * @ORM\PostPersist 
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

		$em->createQuery('UPDATE ' . get_class($item) . ' i SET i.sequence = :sequence WHERE i.id = :id')
			->setParameters([
				'sequence' => $sequenceNext,
				'id' => $item->getId()
			])
			->execute();
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
		if(!$event->hasChangedField('sequence')){
			return;
		}
		$oldSequence = $event->getOldValue('sequence');
		$newSequence = $event->getNewValue('sequence');

		$em = $event->getEntityManager();

		//posouvam o jedno, ci-li v $newSequence je hodnota toho na ktere posouvam
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
