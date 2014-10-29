<?php

namespace JiriNapravnik\Grid\Datasources;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Grido\DataSources\Doctrine;

/**
 * Grid Factory - set default language
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class DoctrineWithAdditionalColumn extends Doctrine
{
	public function getData()
	{
		// Paginator is better if the query uses ManyToMany associations
		$usePaginator = $this->qb->getMaxResults() !== NULL || $this->qb->getFirstResult() !== NULL;
		$data = [];

		if ($usePaginator) {
			$paginator = new Paginator($this->getQuery());

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
