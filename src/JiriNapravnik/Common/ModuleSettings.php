<?php

namespace JiriNapravnik\Common;

use Nette\Object;

class ModuleSettings extends Object
{

	private $parameters;

	public function __construct(\Nette\DI\Container $container)
	{
		$this->parameters = $container->parameters;
		$neon = new \Nette\DI\Config\Adapters\NeonAdapter();
		$appSettings = $neon->load($this->parameters['appDir'] . '/AppModule/config/app.settings.neon');
		$appParams = isset($appSettings['common']) ? $appSettings['common']['parameters'] : $appSettings['parameters'];
		if (isset($appSettings['development']) && $this->parameters['environment'] === 'development') {
			$appParams = array_replace_recursive($appParams, $appSettings['development']['parameters']);
		}
		unset($appParams['app']);
		
		$this->parameters = array_replace_recursive($this->parameters, $appParams);

		$this->parameters = $container->expand($this->parameters);
	}

	public function __call($name, $args)
	{
		try {
			parent::__call($name, $args);
		} catch (\Nette\MemberAccessException $ex) {
			$parameter = lcfirst(str_replace('get', '', $name));
			if (!isset($this->parameters[$this->key][$parameter])) {
				throw new \JiriNapravnik\InvalidArgumentException('Parameter ' . $parameter . ' is not defined');
			}

			return $this->parameters[$this->key][$parameter];
		}
	}

//	public function &__get($name)
//	{
//		try {
//			parent::__get($name);
//		} catch (\Nette\MemberAccessException $ex) {
//			if (!isset($this->parameters[$this->key][$name])) {
//				throw new \JiriNapravnik\InvalidArgumentException('Parameter ' . $name . ' is not defined');
//			}
//
//			return $this->parameters[$this->key][$name];
//		}
//	}

}
