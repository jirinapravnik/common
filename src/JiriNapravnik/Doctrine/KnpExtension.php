<?php

/**
 * KnpExtenstion
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2014, Jiří Nápravník
 */

namespace JiriNapravnik\Doctrine;

class KnpExtension extends \Nette\DI\CompilerExtension
{

	protected $defaults = [
		'all' => FALSE,
		'blameable' => FALSE,
		'filterable' => FALSE,
		'geocodable' => FALSE,
		'loggable' => FALSE,
		'sluggable' => FALSE,
		'softdeletable' => FALSE,
		'timestampable' => FALSE,
		'translatable' => FALSE,
		'config' => [
			'reflection' => [
				'classAnalyzer' => 'Knp\DoctrineBehaviors\Reflection\ClassAnalyzer',
				'isRecursive' => TRUE,
			],
			'blameable' => [
				'blameableTrait' => 'Knp\DoctrineBehaviors\Model\Blameable\Blameable',
				'userCallable' => 'Knp\DoctrineBehaviors\ORM\Blameable\UserCallable',
				'userEntity' => NULL,
			],
			'geocodable' => [
				'geocodableTrait' => 'Knp\DoctrineBehaviors\Model\Geocodable\Geocodable',
			],
			'loggable' => [
				'loggerCallable' => 'Knp\DoctrineBehaviors\ORM\Loggable\LoggerCallable',
			],
			'sluggable' => [
				'sluggableTrait' => 'Knp\DoctrineBehaviors\Model\Sluggable\Sluggable',
			],
			'softdeletable' => [
				'softDeletableTrait' => 'Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable',
			],
			'timestampable' => [
				'timestampableTrait' => 'Knp\DoctrineBehaviors\Model\Timestampable\Timestampable',
			],
			'translatable' => [
				'currentLocaleCallable' => NULL,
				'translatableTrait' => 'Knp\DoctrineBehaviors\Model\Translatable\Translatable',
				'translationTrait' => 'Knp\DoctrineBehaviors\Model\Translatable\Translation',
				'translatableFetchMode' => 'LAZY',
				'translationFetchMode' => 'LAZY',
			],
		]
	];
	
	private $listeners = [
		'blameable' => 'Knp\DoctrineBehaviors\ORM\Blameable\BlameableListener',
		'geocodable' => 'Knp\DoctrineBehaviors\ORM\Geocodable\GeocodableListener',
		'loggable' => 'Knp\DoctrineBehaviors\ORM\Loggable\LoggableListener',
		'sluggable' => 'Knp\DoctrineBehaviors\ORM\Sluggable\SluggableListener',
		'softdeletable' => 'Knp\DoctrineBehaviors\ORM\SoftDeletable\SoftDeletableListener',
		'timestampable' => 'Knp\DoctrineBehaviors\ORM\Timestampable\TimestampableListener',
		'translatable' => 'Knp\DoctrineBehaviors\ORM\Translatable\TranslatableListener',
	];

	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();
		
		$builder->addDefinition('knp.reflection.classAnalyzer')
			->setClass($config['config']['reflection']['classAnalyzer']);

		foreach($this->listeners as $behavior => $listener){
			if(($config[$behavior] || $config['all']) === TRUE){
				$builder->addDefinition($this->prefix($behavior . 'Listener'))
					->setClass($listener, $this->getArgumentsForListener($behavior))
					->setAutowired(FALSE)
					->addTag(\Kdyby\Events\DI\EventsExtension::TAG_SUBSCRIBER);
			}
		}
	}

	private function getArgumentsForListener($listener){
		$config = $this->getConfig($this->defaults);
		
		$arguments = [
			'@knp.reflection.classAnalyzer',
			$config['config']['reflection']['isRecursive'],
		];
		
		foreach($config['config'][$listener] as $key => $value){
			$arguments[$key] = $value;
		}
		
		return $arguments;
	}
	
}
