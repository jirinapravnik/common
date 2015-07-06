<?php

namespace JiriNapravnik\Grid\Datasources;

use Grido\DataSources\Doctrine;
use JiriNapravnik\Doctrine\Tools\Pagination\PaginatorWithoutDistinct;

/**
 * Grid Factory - set default language
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class DoctrineWithoutDistinct extends Doctrine
{
	public function getData()
	{
		// Paginator is better if the query uses ManyToMany associations
		$usePaginator = $this->qb->getMaxResults() !== NULL || $this->qb->getFirstResult() !== NULL;
		$data = [];

		if ($usePaginator) {
			$paginator = new PaginatorWithoutDistinct($this->getQuery(), $this->fetchJoinCollection);
			$paginator->setUseOutputWalkers($this->useOutputWalkers);

			// Convert paginator to the array
			foreach ($paginator as $result) {
				// Return only entity itself
				$data[] = $result;
			}
		} else {

			foreach ($this->qb->getQuery()->getResult() as $result) {
				// Return only entity itself
				$data[] = $result;
			}
		}

		return $data;
	}

}
