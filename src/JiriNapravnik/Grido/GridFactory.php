<?php

namespace JiriNapravnik\Grido;

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

	public function bootstrapModal($row, $element)
	{
		$element->attrs['data'] = array(
			'confirm' => 'modal',
			'confirm-text' => $element->attrs['data']['grido-confirm'],
			'ajax' => 'on',
		);
		unset($element->attrs['data']['grido-confirm']);
		
		return $element;
	}

}
