<?php

/**
 * WebloaderExtension
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2014, Jiří Nápravník
 */

namespace JiriNapravnik\DI;

class WebloaderFilesExtension extends \Nette\DI\CompilerExtension
{

	public function beforeCompile()
	{
		$webloader = $this->compiler->getExtensions('\WebLoader\Nette\Extension')['webloader'];
		foreach ($this->compiler->getExtensions() as $extension) {
			if ($extension instanceof \JiriNapravnik\DI\IWebloaderFilesProvider) {
				$files = $extension->getWebloaderFiles();
				foreach (['css', 'js'] as $type) {
					if (isset($files[$type])) {
						foreach ($files[$type] as $name => $files) {
							$filesDef = $this->getContainerBuilder()->getDefinition($webloader->prefix($type . ucfirst($name) . 'Files'));
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
