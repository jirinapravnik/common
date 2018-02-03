<?php

namespace JiriNapravnik\Grid;

use Ublaboo\DataGrid\DataGrid;

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
	 * @return DataGrid
	 */
	public function create()
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
