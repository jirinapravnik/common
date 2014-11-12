<?php

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/forms
 * @author     Jan Skrasek
 */

namespace JiriNapravnik\Latte\Macros;

use Nette\Forms\Controls\BaseControl;
use Nette\Utils\Html;
use Nextras\Forms\Bridges\Latte\Macros\BaseInputMacros;

class Bootstrap3InputMacros extends BaseInputMacros
{

	public static function label(Html $label, BaseControl $control)
	{
		if ($label->getName() === 'label') {
			$label->addClass('control-label');
		}
		if($control->isRequired()){
			$label->addClass('required');
		}

		return $label;
	}

	public static function input(Html $input, BaseControl $control)
	{
		$name = $input->getName();
		if ($name === 'select' || $name === 'textarea' || ($name === 'input' && !in_array($input->type, array('radio', 'checkbox', 'file', 'hidden', 'range', 'image', 'submit', 'reset')))) {
			$input->addClass('form-control');
		} elseif ($name === 'input' && ($input->type === 'submit' || $input->type === 'reset')) {
			$input->addClass('btn');
//			$input->setName('button');
//			if($input->value !== NULL){
//				$input->add($input->value);
//			}
		}

		return $input;
	}

}
