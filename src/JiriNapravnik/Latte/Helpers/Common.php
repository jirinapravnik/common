<?php

namespace JiriNapravnik\Latte\Helpers;

use DateTime;
use IntlDateFormatter;
use JiriNapravnik\Common\DateCzech;
use Locale;
use Nette\Utils\Html;

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
	
	public static function nl2ul($text, $class){
		if(strlen($text) === 0){
			return;
//			return Html::el('ul class="' . $class . '"');
		}
		$text = '<li>' . str_replace(["\r","\n\n","\n"], ['',"\n","</li>\n<li>"], trim($text, "\n\r")) . '</li>';
		return Html::el('ul class="' . $class . '"')->setHtml($text);
	}
	
	public static function dateLocalized($date)
	{
		$fmt = new IntlDateFormatter(Locale::getDefault(),IntlDateFormatter::LONG, IntlDateFormatter::SHORT);
		return $fmt->format($date);
	}

	public static function monthCzech($monthNumber){
		$months = DateCzech::getCzechMonthsNumericKeys();
		return $months[$monthNumber];
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

		$months = DateCzech::getCzechMonthsNominativ();
		foreach ($months as $en => $cs) {
			$date = str_replace($en, $cs, $date);
		}

		return $date;
	}

	public static function weekdayInCzech($number){
		$weekdays = [
			1 => 'Pondělí',
			2 => 'Úterý',
			3 => 'Středa',
			4 => 'Čtvrtek',
			5 => 'Pátek',
			6 => 'Sobota',
			7 => 'Neděle',
		];
		
		return $weekdays[$number];
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
			return Html::el('strong', array('class' => 'red'))->setText('Soubor není umístěn na serveru!!');
		}
		list($w, $h) = getimagesize($imagePath);
		return $w . 'x' . $h;
	}
	
	public static function correctUrl($url){
		$url = str_replace('http://', '', $url);
		
		return 'http://' . $url;
	}

	/**
	 * Czech helper time ago in words.
	 * @author     David Grudl
	 * @copyright  Copyright (c) 2008, 2009 David Grudl
	 * @param  int
	 * @return string 
	 */
	public static function timeAgoInWords($time)
	{
		if (!$time) {
			return FALSE;
		} elseif (is_numeric($time)) {
			$time = (int) $time;
		} elseif ($time instanceof DateTime) {
			$time = $time->format('U');
		} else {
			$time = strtotime($time);
}

		$delta = time() - $time;

		if ($delta < 0) {
			$delta = round(abs($delta) / 60);
			if ($delta == 0) return 'za okamžik';
			if ($delta == 1) return 'za minutu';
			if ($delta < 45) return 'za ' . $delta . ' ' . self::plural($delta, 'minuta', 'minuty', 'minut');
			if ($delta < 90) return 'za hodinu';
			if ($delta < 1440) return 'za ' . round($delta / 60) . ' ' . self::plural(round($delta / 60), 'hodina', 'hodiny', 'hodin');
			if ($delta < 2880) return 'zítra';
			if ($delta < 43200) return 'za ' . round($delta / 1440) . ' ' . self::plural(round($delta / 1440), 'den', 'dny', 'dní');
			if ($delta < 86400) return 'za měsíc';
			if ($delta < 525960) return 'za ' . round($delta / 43200) . ' ' . self::plural(round($delta / 43200), 'měsíc', 'měsíce', 'měsíců');
			if ($delta < 1051920) return 'za rok';
			return 'za ' . round($delta / 525960) . ' ' . self::plural(round($delta / 525960), 'rok', 'roky', 'let');
		}

		$delta = round($delta / 60);
		if ($delta == 0) return 'před okamžikem';
		if ($delta == 1) return 'před minutou';
		if ($delta < 45) return "před $delta minutami";
		if ($delta < 90) return 'před hodinou';
		if ($delta < 1440) return 'před ' . round($delta / 60) . ' hodinami';
		if ($delta < 2880) return 'včera';
		if ($delta < 43200) return 'před ' . round($delta / 1440) . ' dny';
		if ($delta < 86400) return 'před měsícem';
		if ($delta < 525960) return 'před ' . round($delta / 43200) . ' měsíci';
		if ($delta < 1051920) return 'před rokem';
		return 'před ' . round($delta / 525960) . ' lety';
	}



	/**
	 * Plural: three forms, special cases for 1 and 2, 3, 4.
	 * (Slavic family: Slovak, Czech)
	 * @author     David Grudl
	 * @copyright  Copyright (c) 2008, 2009 David Grudl
	 * @param  int
	 * @return mixed
	 */
	private static function plural($n)
	{
		$args = func_get_args();
		return $args[($n == 1) ? 1 : (($n >= 2 && $n <= 4) ? 2 : 3)];
	}
}
