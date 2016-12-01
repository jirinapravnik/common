<?php

/**
 * WebloaderExtension
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2014, Jiří Nápravník
 */

namespace JiriNapravnik\WebLoader\DI;

class WebLoaderFilesExtension extends \Nette\DI\CompilerExtension
{

	public function beforeCompile()
	{
		$webloader = $this->compiler->getExtensions('\WebLoader\Nette\Extension')['webloader'];
		foreach ($this->compiler->getExtensions() as $extension) {
			if ($extension instanceof \JiriNapravnik\DI\IWebloaderFilesProvider) {
				$assets = $extension->getWebloaderFiles();
				foreach (['css', 'js'] as $assetsType) {
					if (isset($assets[$assetsType])) {
						foreach ($assets[$assetsType] as $name => $files) {
							$filesDef = $this->getContainerBuilder()->getDefinition($webloader->prefix($assetsType . ucfirst($name) . 'Files'));
							foreach ($files as $file) {
								$filesDef->addSetup('addFile', [$file]);
							}
						}
					}
				}
			}
		}
	}

}
