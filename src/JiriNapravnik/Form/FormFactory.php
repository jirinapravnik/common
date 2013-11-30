<?php

/**
 * Base Form
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 * 
 */

namespace JiriNapravnik\Form;

use Kdyby\BootstrapFormRenderer\BootstrapRenderer;
use Nette\Application\UI\Form;

class FormFactory
{

	public function create()
	{
		$form = new Form();
		$form->setRenderer(new BootstrapRenderer());

		return $form;
	}

}
