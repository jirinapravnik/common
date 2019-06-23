<?php

namespace JiriNapravnik\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
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
class BaseEntity
{
	use HydrateExtractEntityTrait;

}
