<?php

namespace JiriNapravnik\Latte\Filters;

use DateTime;
use Flame\Modules\Template\IHelperProvider;
use IntlDateFormatter;
use JiriNapravnik\Common\DateCzech;
use Latte\Engine;
use Locale;

/*
 * Helpers for latte
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */

class Date implements IHelperProvider
{
	
	public function dateLocalized($date)
	{
		$fmt = new IntlDateFormatter(Locale::getDefault(),IntlDateFormatter::LONG, IntlDateFormatter::SHORT);
		return $fmt->format($date);
	}

	public function monthCzech($monthNumber){
		$months = DateCzech::getCzechMonthsNumericKeys();
		return $months[$monthNumber];
	}
	
	public function dateCzech($date, $format)
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

	public function weekdayInCzech($number){
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
	
	public function dateTodayYesterday($date, $formatShort = 'H:i', $formatLong = 'd.m. H:i')
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

	public function czechHoliday($date, $format, $separator = ' - ')
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

	public function register(Engine $engine)
	{
		$engine->addFilter('dateCzech', function($date, $format){
			return $this->dateCzech($date, $format);
		});
		$engine->addFilter('dateLocalized', function($date){
			return $this->dateLocalized($date);
		});
		$engine->addFilter('monthCzech', function($monthNumber){
			return $this->monthCzech($monthNumber);
		});
		$engine->addFilter('timeAgoInWords', function($time){
			return $this->timeAgoInWords($time);
		});
		$engine->addFilter('dateTodayYesterday', function($date, $formatShort = 'H:i', $formatLong = 'd.m. H:i'){
			return $this->dateTodayYesterday($date, $formatShort, $formatLong);
		});
		$engine->addFilter('czechHoliday', function($date, $format, $separator = ' - '){
			return $this->czechHoliday($date, $format, $separator);
		});
	}
}
