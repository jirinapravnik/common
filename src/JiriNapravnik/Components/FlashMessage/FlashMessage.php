<?php

namespace JiriNapravnik\Components\FlashMessage;

use Nette\Application\UI\Control;

class FlashMessage extends Control
{
	
	public function __construct()
	{
		;
	}
	
	public function render()
	{
		$this->template->flashes = $this->getParent()->getTemplate()->flashes;
		
		$this->template->render(__DIR__ . '/flashMessage.latte');
	}

}