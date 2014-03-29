<?php

namespace JiriNapravnik\Components\VisualPaginator;

interface IVisualPaginatorFactory
{
	/**
	 * @return VisualPaginator
	 */
	function create();
}