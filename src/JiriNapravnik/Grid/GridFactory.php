<?php

namespace JiriNapravnik\Grid;

use Grido\Components\Filters\Filter;
use Grido\Grid;

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
		
		return $grid;
	}

	public function bootstrapModal($row, $htmlElement)
	{
		$htmlElement->attrs['data'] = array(
			'confirm' => 'modal',
			'confirm-text' => $htmlElement->attrs['data']['grido-confirm'],
			'ajax' => 'on',
		);
		unset($htmlElement->attrs['data']['grido-confirm']);
		
		return $htmlElement;
	}

}
