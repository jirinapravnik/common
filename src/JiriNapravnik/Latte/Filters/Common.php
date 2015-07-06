<?php

namespace JiriNapravnik\Latte\Filters;

use DateTime;
use Flame\Modules\Template\IHelperProvider;
use IntlDateFormatter;
use JiriNapravnik\Common\DateCzech;
use Latte\Engine;
use Locale;
use Nette\Utils\Html;

/*
 * Helpers for latte
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */

class Common implements IHelperProvider
{
	
	public function nl2ul($text, $class){
		if(strlen($text) === 0){
			return;
//			return Html::el('ul class="' . $class . '"');
		}
		$text = '<li>' . str_replace(["\r","\n\n","\n"], ['',"\n","</li>\n<li>"], trim($text, "\n\r")) . '</li>';
		return Html::el('ul class="' . $class . '"')->setHtml($text);
	}
	
	
	public function imageSize($imagePath)
	{
		if (!file_exists($imagePath)) {
			return Html::el('strong', array('class' => 'red'))->setText('Soubor není umístěn na serveru!!');
		}
		list($w, $h) = getimagesize($imagePath);
		return $w . 'x' . $h;
	}
	
	public function correctUrl($url){
		$url = str_replace('http://', '', $url);
		
		return 'http://' . $url;
	}
	
	public function hideIpPart($ip, $hideParts = 1){
		$expl = explode('.', $ip);
		
		$ipOut = [];
		for($i = 0; $i < count($expl) - $hideParts; $i++){
			$ipOut[] = $expl[$i];
		}
		for($i; $i < count($expl); $i++){
			$ipOut[] = 'XXX';
		}
		return implode('.', $ipOut);
	}

	public function register(Engine $engine)
	{
		$engine->addFilter('imageSize', function($imagePath){
			return $this->imageSize($imagePath);
		});
		$engine->addFilter('nl2ul', function($text, $class){
			return $this->nl2ul($text, $class);
		});
		$engine->addFilter('correctUrl', function($url){
			return $this->correctUrl($url);
		});
		$engine->addFilter('hideIpPart', function($ip, $hideParts = 1){
			return $this->hideIpPart($ip, $hideParts);
		});
	}
}
