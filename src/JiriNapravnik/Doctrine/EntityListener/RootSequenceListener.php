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

class RootSequenceListener
{

	/**
	 * @ORM\PrePersist 
	 */
	public function prePersist($item, LifecycleEventArgs $event)
	{
		$this->setMaxRootSequence($item, $event);
	}

	/**
	 * @ORM\PostRemove 
	 */
	public function postRemove($item, LifecycleEventArgs $event)
	{
		if ($item->getLevel() > 0) {
			return;
		}

		$em = $event->getEntityManager();

		$qb = $em->createQueryBuilder();
		$qb->update(get_class($item), 'i')
			->set('i.rootSequence', 'i.rootSequence - 1')
			->where('i.rootSequence > ' . $item->getRootSequence())
			->getQuery()
			->execute();
	}

	/**
	 * @ORM\PreUpdate
	 */
	public function preUpdate($item, PreUpdateEventArgs $event)
	{
		if ($item->getLevel() > 0) {
			$item->setRootSequence(NULL);
		} elseif ($event->hasChangedField('parent') && is_null($event->getNewValue('parent')) && !is_null($event->getOldValue('parent'))) {
			$this->setMaxRootSequence($item, $event);
		} else {
			if(!$event->hasChangedField('rootSequence')){
				return;
			}
			$oldSequence = $event->getOldValue('rootSequence');
			$newSequence = $event->getNewValue('rootSequence');

			if ($oldSequence === $newSequence) {
				return;
			}

			$em = $event->getEntityManager();
			
			$qb = $em->createQueryBuilder();
			$qb->update(get_class($item), 'i')
				->where('i.rootSequence = ' . $newSequence);

			if ($newSequence > $oldSequence) {
				$qb->set('i.rootSequence', 'i.rootSequence - 1');
			} elseif ($newSequence < $oldSequence) {
				$qb->set('i.rootSequence', 'i.rootSequence + 1');
			}

			$qb->getQuery()
				->execute();
		}
	}

	private function setMaxRootSequence($item, LifeCycleEventArgs $event)
	{
		$em = $event->getEntityManager();
		
		$qb = $em->createQueryBuilder();
		$maxSequence = $qb->select('MAX(i.rootSequence)')
			->from(get_class($item), 'i')
			->getQuery()
			->getOneOrNullResult();

		$sequenceNext = (int) $maxSequence[1] + 1;

		if (is_null($item->getParent())) {
			$item->setRootSequence($sequenceNext);
		}
	}

}
