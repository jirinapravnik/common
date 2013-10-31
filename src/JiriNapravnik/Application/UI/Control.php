<?php

namespace JiriNapravnik\Application\UI;

use Nette;

/**
 * Base Control
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class Control extends Nette\Application\UI\Control
{

	use \Nextras\Application\UI\SecuredLinksPresenterTrait;
}
