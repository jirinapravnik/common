<?php

/**
 * Base Form
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 * 
 */

namespace JiriNapravnik\Nette;

use Kdyby\BootstrapFormRenderer\BootstrapRenderer;
use Nette\Application\UI\Form;

class BaseFormFactory
{

	public function create()
	{
		$form = new Form();
		$form->setRenderer(new BootstrapRenderer());

		return $form;
	}

}
