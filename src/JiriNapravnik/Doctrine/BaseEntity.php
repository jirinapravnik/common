<?php

namespace JiriNapravnik\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Kdyby\Doctrine\Entities\BaseEntity as KdybyEntity;
use Nette\ArrayHash;
use Nette\Http\FileUpload;
use ReflectionClass;
use ReflectionProperty;
use Zend\Stdlib\Hydrator;

/**
 * BaseEntity for Doctrine
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class BaseEntity extends KdybyEntity
{
	public function extract()
	{

		$reflection = new ReflectionClass($this);
		$details = array();
		foreach ($reflection->getProperties(ReflectionProperty::IS_PROTECTED) as $property) {
			if (!$property->isStatic()) {
				$value = $this->{$property->getName()};

				if ($value instanceof BaseEntity) {
					$value = $value->getId();
				} elseif ($value instanceof ArrayCollection || $value instanceof PersistentCollection) {
					$value = array_map(function (BaseEntity $entity) {
						return $entity->getId();
					}, $value->toArray());
				}
				$details[$property->getName()] = $value;
			}
		}
		return $details;

//		$hydrator = new Hydrator\ClassMethods(FALSE);
//		return $hydrator->extract($this);
	}

	public function hydrate($values)
	{
		if ($values instanceof ArrayHash) {
			$values = (array) $values;
		}
		
		foreach ($values as $key => $value) {
			if (is_string($value) && $value == '') {
				unset($values[$key]);
			}
			if ($value instanceof FileUpload && !$value->isOk()) {
				unset($values[$key]);
			}
			if ($value instanceof ArrayHash) {
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
