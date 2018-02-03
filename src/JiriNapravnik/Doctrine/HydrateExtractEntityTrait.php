<?php
/**
 * Created by PhpStorm.
 * User: jirin
 * Date: 16.11.2017
 * Time: 23:56
 */

namespace JiriNapravnik\Doctrine;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Nette\Http\FileUpload;
use Nette\Utils\ArrayHash;
use Zend\Stdlib\Hydrator\ClassMethods;

trait HydrateExtractEntityTrait
{
    public function extract(array $exclude = [])
    {

        $reflection = new \ReflectionClass($this);
        $details = array();
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PROTECTED) as $property) {
            if (!$property->isStatic()) {
                $value = $this->{$property->getName()};

                if (!in_array($property->getName(), $exclude) && $value instanceof BaseEntity) {
                    $value = $value->getId();
                } elseif (!in_array($property->getName(), $exclude) && ($value instanceof ArrayCollection || $value instanceof PersistentCollection)) {
                    $value = array_map(function ($entity) {
                        if (method_exists($entity, 'getId')) {
                            return $entity->getId();
                        }
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
                $values[$key] = NULL;
            }
            if ($value instanceof FileUpload && !$value->isOk()) {
                unset($values[$key]);
            }
            if ($value instanceof ArrayHash) {
                $values[$key] = $this->arrayHashToArray($value);
            }
        }
        $hydrator = new ClassMethods();
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