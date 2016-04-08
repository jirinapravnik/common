<?php

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras/forms
 * @author     Jan Tvrdik (http://merxes.cz)
 */

namespace JiriNapravnik\Form\Controls;

use Nette;
use Nette\Forms;
use Nette\Forms\Controls\TextBase;

/**
 * Form control for selecting date.
 *
 * @author   Jan Tvrdik
 * @author   Jan Skrasek
 */
class DatePicker extends \Nextras\Forms\Controls\DatePicker
{
	protected $htmlFormat = 'j. n. Y';

	public function getControl()
	{
		$control = parent::getControl();
		$control->type = 'text';

		return $control;
	}

}
