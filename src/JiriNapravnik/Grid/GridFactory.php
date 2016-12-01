<?php

namespace JiriNapravnik\Grid;

use Grido\Components\Filters\Filter;
use Grido\Grid;
use Grido\Customization;

/**
 * Grid Factory - set default language
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class GridFactory
{

	/**
	 * 
	 * @return \Grido\Grid
	 */
	public function create()
	{
		$grid = new Grid();
		$grid->getTranslator()->setLang('cs');
		$grid->setFilterRenderType(Filter::RENDER_INNER);
		$grid->customization->useTemplateBootstrap();
		
		return $grid;
	}

	public function bootstrapModal($row, $htmlElement)
	{
		$htmlElement->attrs['data-confirm'] = 'modal';
		$htmlElement->attrs['data-confirm-text'] = $htmlElement->attrs['data-grido-confirm'];
		$htmlElement->attrs['data-ajax'] = 'on';
		
		unset($htmlElement->attrs['data-grido-confirm']);
		
		return $htmlElement;
	}

}
