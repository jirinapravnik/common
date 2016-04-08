<?php

/**
 * Base Form
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 * 
 */

namespace JiriNapravnik\Form;

use JiriNapravnik\Form\Controls\AntispamControl;
use JiriNapravnik\Form\Controls\DateInput;
use JiriNapravnik\Form\Controls\TextCaptcha;
use Nette\Application\UI\Form;
use Nette\Forms\Container;

class FormFactory
{

	public function __construct()
	{
		AntispamControl::register();
		
		Container::extensionMethod('addDateInput', function (Container $container, $name, $label = NULL) {
			return $container[$name] = new DateInput($label);
		});
		Container::extensionMethod('addTextCaptcha', function (Container $container, $name, $label = NULL) {
			return $container[$name] = new TextCaptcha($label);
		});
	}

	public function create()
	{
		$form = new Form();
		$form->getElementPrototype()->addClass('form-horizontal');
		$form->setRenderer(new Bs3FormRenderer());

		return $form;
	}

}
