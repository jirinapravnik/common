<?php

namespace JiriNapravnik\Form\Controls;

use Nette\DateTime;
use Nette\Forms\Controls\BaseControl;
use Nette\Forms\Form;
use Nette\Forms\Helpers;
use Nette\Forms\IControl;
use Nette\Utils\Html;

class DateInput extends BaseControl
{

	private $day, $month, $year;

	public function __construct($label = NULL)
	{
		parent::__construct($label);
		$this->addRule(__CLASS__ . '::validateDate', 'Neexistující datum.');
	}

	public function setValue($value)
	{
		if ($value) {
			$date = DateTime::from($value);
			$this->day = $date->format('j');
			$this->month = $date->format('n');
			$this->year = $date->format('Y');
		} else {
			$this->day = $this->month = $this->year = NULL;
		}
	}

	/**
	 * @return DateTime|NULL
	 */
	public function getValue()
	{
		$year = $this->year;
		$month = $this->month;
		$day = $this->day;
		
		$validated = self::validateDate($this);

		if($validated && $year > 0 && $month > 0 && $day > 0){
			return date_create()->setDate($year, $month, $day);
		}
		return NULL;
	}

	public function loadHttpData()
	{
		$this->day = $this->getHttpData(Form::DATA_LINE, '[day]');
		$this->month = $this->getHttpData(Form::DATA_LINE, '[month]');
		$this->year = $this->getHttpData(Form::DATA_LINE, '[year]');
	}

	/**
	 * Generates control's HTML element.
	 */
	public function getControl()
	{

		parent::getControl();

		$days = array('' => 'Den') + array_combine(range(1, 31), range(1, 31));
		$yearsRange = range(date('Y'), date('Y') - 110);
		$years = array('' => 'Rok') + array_combine($yearsRange, $yearsRange);

		$monthsCzech = \JiriNapravnik\Common\DateCzech::getCzechMonthsNumericKeys();
		$months = array('' => 'Měsíc');
		for ($i = 1; $i <= 12; $i++) {
			$months[$i] = $monthsCzech[$i];
		}

		$name = $this->getHtmlName();

		return Html::el()
				->add(Helpers::createSelectBox(
						$days, array('selected?' => $this->day)
					)->name($name . '[day]')
					->class('form-control day')
				)
				->add(Helpers::createSelectBox(
						$months, array('selected?' => $this->month)
					)->name($name . '[month]')
					->class('form-control month')
				)
				->add(Helpers::createSelectBox(
						$years, array('selected?' => $this->year)
					)->name($name . '[year]')
					->class('form-control year')
		);
	}

	/**
	 * @return bool
	 */
	public static function validateDate(IControl $control)
	{
		$year = $control->year;
		$month = $control->month;
		$day = $control->day;

		if (!$control->isRequired() && $year === $month && $month === $day && $day === '') {
			return TRUE;
		} elseif ($year > 0 && $month > 0 && $day > 0) {
			return checkdate($month, $day, $year);
		} else {
			return FALSE;
		}
	}

}
