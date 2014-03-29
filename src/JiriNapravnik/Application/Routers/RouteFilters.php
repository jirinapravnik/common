<?php

/**
 * router filters
 */

namespace JiriNapravnik\Application\Routers;

use Nette;

final class RouteFilters extends Nette\Application\Routers\Route
{
	
	public static function removeHttpFromUrl($url){
	//	echo 'in';
	//\Nette\Diagnostics\Debugger::dump($url);exit;
		return substr($url, 7);
	}
	
	public static function addHttpToUrl($url){
	//\Nette\Diagnostics\Debugger::dump($url);exit;
		return 'http://' . $url;
	}
	
}
