<?php declare(strict_types = 1);

namespace JiriNapravnik\DI\ExtensionTraits;

use Doctrine\Common\Persistence\Mapping\Driver\AnnotationDriver;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\DI\ContainerBuilder;
use Nette\Utils\Validators;

trait TAddLatteFilterClass
{

	public function addLatteFilterClass(string $helperClass): void
	{
		/** @var ContainerBuilder $builder */
		$builder = $this->getContainerBuilder();

		Validators::assert($helperClass, 'string');

		$latteFactory = $builder->getDefinition('nette.latteFactory');

		$provider = $builder->addDefinition($this->prefix('helperProvider.' . \Nette\Utils\Random::generate() . '.' . str_replace('\\', '', $helperClass)))
			->setClass($helperClass);

		$latteFactory->getResultDefinition()->addSetup('?->register($service)', array($provider));
	}

}
