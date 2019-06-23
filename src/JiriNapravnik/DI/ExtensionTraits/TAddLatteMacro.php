<?php declare(strict_types = 1);

namespace JiriNapravnik\DI\ExtensionTraits;

use Doctrine\Common\Persistence\Mapping\Driver\AnnotationDriver;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\DI\ContainerBuilder;
use Nette\Utils\Validators;

trait TAddLatteMacro
{

	public function addLatteMacro(string $macro): void
	{
		/** @var ContainerBuilder $builder */
		$builder = $this->getContainerBuilder();

		Validators::assert($macro, 'string', 'macro');

		$latteFactory = $builder->getDefinition('nette.latteFactory');
		if (strpos($macro, '::') === FALSE && class_exists($macro)) {
			$macro .= '::install';
		} else {
			Validators::assert($macro, 'callable', 'macro');
		}

		$latteFactory->getResultDefinition()->addSetup('?->onCompile[] = function($engine) { ' . $macro . '($engine->getCompiler()); }', array('@self'));
	}

}
