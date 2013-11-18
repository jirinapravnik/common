<?php

/**
 * Base Form
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 * 
 */

namespace JiriNapravnik\Nette;

class BaseForm extends \Nette\Application\UI\Form
{

	public function __construct(\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
	{
		parent::__construct($parent, $name);
		$this->setRenderer(new \Kdyby\BootstrapFormRenderer\BootstrapRenderer());
	}

}
