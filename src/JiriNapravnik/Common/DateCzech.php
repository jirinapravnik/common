<?php

/**
 * DateTime
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */

namespace JiriNapravnik\Common;

use DateTime;

class DateCzech
{

	public static function getCzechWeekDays()
	{
		$weekDays = array(
			'Monday' => 'Pondělí', 'Tuesday' => 'Úterý',
			'Wednesday' => 'Středa', 'Thursday' => 'Čtvrtek',
			'Friday' => 'Pátek', 'Saturday' => 'Sobota',
			'Sunday' => 'Neděle'
		);

		return $weekDays;
	}
	
	public static function getCzechMonthsNominativ()
	{
		$months = array(
			'January' => 'ledna', 'February' => 'února', 'March' => 'března',
			'April' => 'dubna', 'May' => 'května', 'June' => 'června',
			'July' => 'července', 'August' => 'srpna', 'September' => 'září',
			'October' => 'října', 'November' => 'listopadu',
			'December' => 'prosince'
		);

		return $months;
	}
	

	public static function getCzechMonthsNumericKeys()
	{
		$months = array(
			1 => 'leden', 'únor', 'březen',
			'duben', 'květen', 'červen',
			'červenec', 'srpen', 'září',
			'říjen', 'listopad', 'prosinec'
		);

		return $months;
	}
	
	public static function getCzechMonthsNominativNumericKeys()
	{
		$months = array(
			1 => 'ledna', 'února', 'března',
			'dubna', 'května', 'června',
			'července', 'srpna', 'září',
			'října', 'listopadu', 'prosince'
		);

		return $months;
	}

	public static function getCzechHolidayForDate(DateTime $date)
	{

		$month01 = array(
			'@je Nový rok', 'Karina', 'Radmila', 'Diana', 'Dalimil',
			'@jsou Tři králové', 'Vilma', 'Čestmír', 'Vladan', 'Břetislav', 'Bohdana',
			'Pravoslav', 'Edita', 'Radovan', 'Alice', 'Ctirad', 'Drahoslav', 'Vladislav',
			'Doubravka', 'Ilona', 'Běla', 'Slavomír', 'Zdeněk', 'Milena', 'Miloš', 'Zora',
			'Ingrid', 'Otýlie', 'Zdislava', 'Robin', 'Marika'
		);

		$month02 = array(
			'Hynek', 'Nela', 'Blažej', 'Jarmila', 'Dobromila', 'Vanda', 'Veronika', 'Milada',
			'Apolena', 'Mojmír', 'Božena', 'Slavěna', 'Věnceslav', 'Valentýn', 'Jiřina',
			'Ljuba', 'Miloslava', 'Gizela', 'Patrik', 'Oldřich', 'Lenka', 'Petr', 'Svatopluk',
			'Matěj', 'Liliana', 'Dorota', 'Alexandr', 'Lumír', 'Horymír'
		);

		$month03 = array(
			'Bedřich', 'Anežka', 'Kamil', 'Stela', 'Kazimír', 'Miroslav', 'Tomáš', 'Gabriela',
			'Františka', 'Viktorie', 'Anděla', 'Řehoř', 'Růžena', 'Rút a Matylda', 'Ida',
			'Elena a Herbert', 'Vlastimil', 'Eduard', 'Josef', 'Světlana', 'Radek', 'Leona',
			'Ivona', 'Gabriel', 'Marián', 'Emanuel', 'Dita', 'Soňa', 'Taťána', 'Arnošt', 'Kvido'
		);

		$month04 = array(
			'Hugo', 'Erika', 'Richard', 'Ivana', 'Miroslava', 'Vendula', 'Heřman a Hermína',
			'Ema', 'Dušan', 'Darja', 'Izabela',
			'Julius', 'Aleš', 'Vincenc', 'Anastázie',
			'Irena', 'Rudolf', 'Valérie', 'Rostislav', 'Marcela', 'Alexandra', 'Evženie',
			'Vojtěch', 'Jiří', 'Marek', 'Oto', 'Jaroslav', 'Vlastislav', 'Robert', 'Blahoslav'
		);

		$month05 = array(
			'@je Svátek práce', 'Zikmund', 'Alexej', 'Květoslav', 'Klaudie', 'Radoslav',
			'Stanislav', '@je Den osvobození od fašismu', 'Ctibor', 'Blažena', 'Svatava',
			'Pankrác', 'Servác', 'Bonifác', 'Žofie', 'Přemysl', 'Aneta', 'Nataša', 'Ivo',
			'Zbyšek', 'Monika', 'Emil', 'Vladimír', 'Jana', 'Viola', 'Filip', 'Valdemar',
			'Vilém', 'Maxmilián', 'Ferdinand', 'Kamila'
		);

		$month06 = array(
			'Laura', 'Jarmil', 'Tamara', 'Dalibor', 'Dobroslav', 'Norbert', 'Iveta a Slavoj',
			'Medard', 'Stanislava', 'Gita', 'Bruno', 'Antonie', 'Antonín', 'Roland', 'Vít',
			'Zbyněk', 'Adolf', 'Milan', 'Leoš', 'Květa', 'Alois', 'Pavla', 'Zdeňka', 'Jan',
			'Ivan', 'Adriana', 'Ladislav', 'Lubomír', 'Petr a Pavel', 'Šárka'
		);

		$month07 = array(
			'Jaroslava', 'Patricie', 'Radomír', 'Prokop', '@je Den slovanských věrozvěstů',
			'Mistr Jan Hus', 'Bohuslava', 'Nora', 'Drahoslava', 'Libuše a Amálie', 'Olga',
			'Bořek', 'Markéta', 'Karolína', 'Jindřich', 'Luboš', 'Martina', 'Drahomíra',
			'Čeněk', 'Ilja', 'Vítězslav', 'Magdaléna', 'Libor', 'Kristýna', 'Jakub', 'Anna',
			'Věroslav', 'Viktor', 'Marta', 'Bořivoj', 'Ignác'
		);

		$month08 = array(
			'Oskar', 'Gustav', 'Miluše', 'Dominik', 'Kristián', 'Oldřiška', 'Lada', 'Soběslav',
			'Roman', 'Vavřinec', 'Zuzana', 'Klára', 'Alena', 'Alan', 'Hana', 'Jáchym', 'Petra',
			'Helena', 'Ludvík', 'Bernard', 'Johana', 'Bohuslav', 'Sandra', 'Bartoloměj',
			'Radim', 'Luděk', 'Otakar', 'Augustýn', 'Evelína', 'Vladěna', 'Pavlína'
		);

		$month09 = array(
			'Linda a Samuel', 'Adéla', 'Bronislav', 'Jindřiška', 'Boris', 'Boleslav',
			'Regína', 'Mariana', 'Daniela', 'Irma', 'Denisa', 'Marie', 'Lubor', 'Radka',
			'Jolana', 'Ludmila', 'Naděžda', 'Kryštof', 'Zita', 'Oleg', 'Matouš', 'Darina',
			'Berta', 'Jaromír', 'Zlata', 'Andrea', 'Jonáš', 'Václav', 'Michal', 'Jeroným'
		);

		$month10 = array(
			'Igor', 'Olívie a Oliver', 'Bohumil', 'František', 'Eliška', 'Hanuš', 'Justýna',
			'Věra', 'Štefan a Sára', 'Marina', 'Andrej', 'Marcel', 'Renáta', 'Agáta', 'Tereza',
			'Havel', 'Hedvika', 'Lukáš', 'Michaela', 'Vendelín', 'Brigita', 'Sabina', 'Teodor',
			'Nina', 'Beáta', 'Erik', 'Šarlota a Zoe', '@je Den samostatného československého státu',
			'Silvie', 'Tadeáš', 'Štěpánka'
		);

		$month11 = array(
			'Felix', '@je Památka zesnulých', 'Hubert', 'Karel', 'Miriam', 'Liběna', 'Saskie',
			'Bohumír', 'Bohdan', 'Evžen', 'Martin', 'Benedikt', 'Tibor', 'Sáva', 'Leopold',
			'Otmar', '@je Den boje studentů a svátek má Mahulena', 'Romana', 'Alžběta',
			'Nikola', 'Albert', 'Cecílie', 'Klement', 'Emílie', 'Kateřina', 'Artur', 'Xenie',
			'René', 'Zina', 'Ondřej'
		);

		$month12 = array(
			'Iva', 'Blanka', 'Svatoslav', 'Barbora', 'Jitka', 'Mikuláš', 'Benjamín', 'Květoslava',
			'Vratislav', 'Julie', 'Dana', 'Simona', 'Lucie', 'Lýdie', 'Radana a Radan', 'Albína',
			'Daniel', 'Miloslav', 'Ester', 'Dagmar', 'Natálie', 'Šimon', 'Vlasta',
			'@je Štědrý den a svátek má Adam a Eva', '@je 1. svátek vánoční',
			'@je 2. svátek vánoční a svátek má Štěpán', 'Žaneta', 'Bohumila', 'Judita',
			'David', 'Silvestr'
		);

		$monthVar = 'month' . $date->format('m');
		$monthDate = $$monthVar;

		return $monthDate[$date->format('j') - 1];
	}

}
