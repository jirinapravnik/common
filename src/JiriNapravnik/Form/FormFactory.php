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
use Nette\Http\Session;

class FormFactory
{

	public function __construct(Session $session)
	{
		AntispamControl::register();
		
		Container::extensionMethod('addDateInput', function (Container $container, $name, $label = NULL) {
			return $container[$name] = new DateInput($label);
		});
		Container::extensionMethod('addTextCaptcha', function (Container $container, $name, $label = NULL)  use ($session){
			$textCaptcha = new TextCaptcha($label);
			$textCaptcha->setSession($session);
			return $container[$name] = $textCaptcha;
		});
	}

	public function create()
	{
		$form = new Form();
		$form->getElementPrototype()->addClass('form-horizontal');
		$form->setRenderer(new Bs4FormRenderer());

		return $form;
	}

}
