<?php

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/forms
 * @author     Jan Skrasek
 */

namespace JiriNapravnik\Form\Controls;

use DateTime;
use Nette\Forms\Controls\TextBase;
use Nette;

class DateTimePicker extends \Nextras\Forms\Controls\DateTimePicker
{
	protected $htmlFormat = 'j. n. Y - H:i';


	public function getControl()
	{
		$control = parent::getControl();
		$control->type = 'text';
		
		return $control;
	}

}
