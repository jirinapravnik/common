<?php

namespace JiriNapravnik\Application\UI;

use Nette;

/**
 * Base Presenter
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class Presenter extends Nette\Application\UI\Presenter
{

	use \Nextras\Application\UI\SecuredLinksPresenterTrait;
}
