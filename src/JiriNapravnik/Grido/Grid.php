<?php

namespace JiriNapravnik\Grido;

use JiriNapravnik\Grido\Grid;
use Nette\ComponentModel\IContainer;

/**
 * Base Grid - set default language
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class Grid extends Grid
{

	public function __construct(IContainer $parent = NULL, $name = NULL)
	{
		parent::__construct($parent, $name);
		$this->getTranslator()->setLang('cs');
	}

}
