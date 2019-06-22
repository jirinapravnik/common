<?php declare(strict_types = 1);

namespace JiriNapravnik\DI\ExtensionTraits;

use Doctrine\Common\Persistence\Mapping\Driver\AnnotationDriver;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\DI\ContainerBuilder;
use Nette\DI\Extensions\InjectExtension;
use Nette\DI\Statement;
use Nette\Utils\Reflection;
use Nette\Utils\Validators;

trait TAddRouterFactory
{

	public function addRouterFactory(string $routerFactoryClass): void
	{
		/** @var ContainerBuilder $builder */
		$builder = $this->getContainerBuilder();

		Validators::assert($routerFactoryClass, 'string');

		$router = $builder->getDefinition('router');

		$serviceName = $this->prefix('routeService.' . md5($routerFactoryClass));
		$builder->addDefinition($serviceName)
			->setClass($routerFactoryClass)
			->addTag(InjectExtension::TAG_INJECT);

		$factory = new Statement(array('@' . $serviceName, 'createRouter'));
		$router->addSetup('offsetSet', [NULL, $factory]);
	}


	private function addRouteService(string $class): string
	{
		$serviceName = md5($class);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('routeService.' . $serviceName))
			->setClass($class)
			->addTag(InjectExtension::TAG_INJECT);

		$builder->addDefinition('routerServiceFactory.' . $serviceName)
			->setFactory($this->prefix('@routeService.' . $serviceName) . '::createRouter')
			->setAutowired(FALSE);

		return '@routerServiceFactory.' . $serviceName;
	}
}
