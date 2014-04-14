<?php

namespace JiriNapravnik\Latte\Helpers;

use DateTime;
use JiriNapravnik\Common\DateCzech;

/*
 * Helpers for latte
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */

class Common
{

	public static function loader($helper)
	{
		if (method_exists(__CLASS__, $helper)) {
			return array(__CLASS__, $helper);
		}
	}

	public static function dateCzech($date, $format)
	{
		if (!$date instanceof DateTime) {
			$date = new DateTime($date);
		}

		$date = $date->format($format);

		$weekDays = DateCzech::getCzechWeekDays();
		foreach ($weekDays as $en => $cs) {
			$date = str_replace($en, $cs, $date);
		}

		$months = DateCzech::getCzechMonths();
		foreach ($months as $en => $cs) {
			$date = str_replace($en, $cs, $date);
		}

		return $date;
	}

	public static function dateTodayYesterday($date, $formatShort, $formatLong)
	{
		if (!$date instanceof DateTime) {
			$date = new DateTime($date);
		}
		
		$today = new DateTime('today');
		$yesterday = new DateTime('yesterday');
		if($date->format('Y-m-d') === $today->format('Y-m-d')){
			return 'dnes ' . $date->format($formatShort);
		} elseif($date->format('Y-m-d') === $yesterday->format('Y-m-d')){
			return 'včera ' . $date->format($formatShort);
		} else {
			return $date->format($formatLong);
		}
	}

	public static function czechHoliday($date, $format, $separator = ' - ')
	{
		if (!$date instanceof DateTime) {
			$date = new DateTime($date);
		}
		$dateHoliday = DateCzech::getCzechHolidayForDate($date);

		if (substr($dateHoliday, 0, 1) == '@') {
			return 'Dnes ' . substr($dateHoliday, 1);
		} else {
			return self::dateCzech($date, $format) . $separator . 'Svátek má ' . $dateHoliday . '.';
		}
	}

	public static function imageSize($imagePath)
	{
		if (!file_exists($imagePath)) {
			return \Nette\Utils\Html::el('strong', array('class' => 'red'))->setText('Soubor není umístěn na serveru!!');
		}
		list($w, $h) = getimagesize($imagePath);
		return $w . 'x' . $h;
	}

}
