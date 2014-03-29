<?php

/**
 * Base Form
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 * 
 */

namespace JiriNapravnik\Form;

use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nextras\Forms\Controls;

class FormFactory
{

	public function __construct()
	{
		Container::extensionMethod('addOptionList', function (Container $container, $name, $label = NULL, array $items = NULL) {
			return $container[$name] = new Controls\OptionList($label, $items);
		});
		Container::extensionMethod('addMultiOptionList', function (Container $container, $name, $label = NULL, array $items = NULL) {
			return $container[$name] = new Controls\MultiOptionList($label, $items);
		});
		Container::extensionMethod('addDatePicker', function (Container $container, $name, $label = NULL) {
			return $container[$name] = new Controls\DatePicker($label);
		});
		Container::extensionMethod('addDateTimePicker', function (Container $container, $name, $label = NULL) {
			return $container[$name] = new Controls\DateTimePicker($label);
		});
		Container::extensionMethod('addTypeahead', function(Container $container, $name, $label = NULL, $callback = NULL) {
			return $container[$name] = new Controls\Typeahead($label, $callback);
		});
		Container::extensionMethod('addDateInput', function (Container $container, $name, $label = NULL) {
			return $container[$name] = new \JiriNapravnik\Form\Controls\DateInput($label);
		});
	}

	public function create()
	{
		$form = new Form();
		$form->getElementPrototype()->addClass('form-horizontal');
		$form->setRenderer(new \JiriNapravnik\Form\Bs3FormRenderer());

		return $form;
	}

}
