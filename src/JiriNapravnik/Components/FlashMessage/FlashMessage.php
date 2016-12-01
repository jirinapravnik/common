<?php

namespace JiriNapravnik\Components\FlashMessage;

use Nette\Application\UI\Control;

class FlashMessage extends Control
{
	private $templateFile = __DIR__ . '/flashMessage.latte';
	
	public function setTemplateFile($templateFile){
		$this->templateFile = $templateFile;
		return $this;
	}
	
	public function render()
	{
		$this->template->flashes = $this->getParent()->getTemplate()->flashes;
		
		$this->template->render($this->templateFile);
	}

}