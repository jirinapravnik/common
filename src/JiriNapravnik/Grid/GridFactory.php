<?php

namespace JiriNapravnik\Grid;

use Grido\Components\Filters\Filter;
use Grido\Grid;
use Grido\Customization;
use Ublaboo\DataGrid\DataGrid;

/**
 * Grid Factory - set default language
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class GridFactory
{
	public static $defaultGrid = 'ublaboo';

	public function create(){
		if(self::$defaultGrid === 'ublaboo'){
			return $this->createUblaboo();
		} elseif(self::$defaultGrid === 'grido'){
			return $this->createGrido();
		}			
	}

	/**
	 * 
	 * @return \Grido\Grid
	 */
	public function createGrido()
	{
		$grid = new Grid();
		$grid->getTranslator()->setLang('cs');
		$grid->setFilterRenderType(Filter::RENDER_INNER);
		$grid->customization->useTemplateBootstrap();
		
		return $grid;
	}
	
	/**
	 * 
	 * @return DataGrid
	 */
	public function createUblaboo()
	{
		$grid = new DataGrid();
		$grid->setRememberState(false);
		$grid->setRefreshUrl(false);
		
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
