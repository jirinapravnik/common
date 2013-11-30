<?php

namespace JiriNapravnik\Doctrine;

use Zend\Stdlib\Hydrator;

/**
 * BaseEntity for Doctrine
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class BaseEntity extends \Kdyby\Doctrine\Entities\BaseEntity
{

	public function extract()
	{
		$hydrator = new Hydrator\ClassMethods(false);
		return $hydrator->extract($this);
	}

	public function hydrate($values)
	{
		if ($values instanceof \Nette\ArrayHash) {
			$values = (array) $values;
		}

		foreach ($values as $key => $value) {
			if (is_string($value) && $value == '') {
				unset($values[$key]);
			}
			if ($value instanceof \Nette\Http\FileUpload && !$value->isOk()) {
				unset($values[$key]);
			}
			if ($value instanceof \Nette\ArrayHash) {
				$values[$key] = $this->arrayHashToArray($value);
			}
		}
		$hydrator = new Hydrator\ClassMethods();
		$hydrator->hydrate($values, $this);
		return $this;
	}

	protected function arrayHashToArray($arrayHash)
	{
		if (is_object($arrayHash)) {
			$arrayHash = (array) $arrayHash;
		}
		if (is_array($arrayHash)) {
			$new = array();
			foreach ($arrayHash as $key => $val) {
				$new[$key] = $this->arrayHashToArray($val);
			}
		} else {
			$new = $arrayHash;
		}
		return $new;
	}

}
