<?php

namespace JiriNapravnik\Component\FlashMessage;

use Nette\Application\UI\Control;

class FlashMessage extends Control
{

	public function render()
	{
		$this->template->flashes = $this->parent->template->flashes;
		$this->template->setFile(__DIR__ . '/flashMessage.latte');
		$this->template->render();
	}

}