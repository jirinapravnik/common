<?php

/**
 * Bs3FormRenderer
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */

namespace JiriNapravnik\Form;

use Nette\Forms\Form;
use Nette\Application\UI;
use Nette\Templating\FileTemplate;
use Nette\Utils\Html;

class Bs3FormRenderer extends \Nextras\Forms\Rendering\Bs3FormRenderer
{

	private $template;

	public function __construct(FileTemplate $template = NULL)
	{
		parent::__construct();

		$this->template = $template;

		$this->wrappers['control']['container'] = 'div class="col-sm-9 controls"';
		$this->wrappers['control']['errorcontainer'] = 'span class="help-block error"';
	}

	public function render(Form $form, $mode = NULL, $control = NULL)
	{
		if ($this->form !== $form) {
			$this->form = $form;
			$this->init();
		}

		if ($mode === 'pair') {
			if (is_string($control)) {
				$control = $form[$control];
			}
			return $this->renderPair($control);
		} elseif ($mode === 'container') {
			return $this->renderControls($control);
		} elseif ($mode === 'errors') {
			return $this->renderAllErrors($form);
		} else {
			$errors = '';
			if ($mode === NULL) {
				$errors = $this->renderAllErrors($form);
			}
			return $errors . parent::render($form, $mode);
		}
	}

	public function renderAllErrors(UI\Form $form)
	{
		$html = '';
		foreach ($form->getErrors() as $error) {
			$html .= '<div class="alert alert-danger">
							<a class="close" data-dismiss="alert">×</a>' . $error . '
						</div>';
		}

		$errors = new Html();
		$errors->setHtml($html);
		return $errors;
	}

}
