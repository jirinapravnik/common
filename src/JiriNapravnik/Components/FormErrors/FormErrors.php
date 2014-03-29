<?php

/**
 * FormErrors
 *
 * @author Jiří Nápravník (jirinapravnik.cz), Enbros.cz
 */

namespace JiriNapravnik\Components\FormErrors;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class FormErrors extends Control
{
	private $form;
	private $cleanErrors;
	
	public function __construct(Form $form, $cleanErrors = TRUE)
	{
		parent::__construct();
		$this->form = $form;
		$this->cleanErrors = $cleanErrors;
	}
	
	public function render(){
		$this->template->formErrors = $this->form->getAllErrors();
		if($this->cleanErrors){
			$this->form->cleanErrors();
		}
		$this->template->setFile(__DIR__ . '/formErrors.latte');
		$this->template->render();
	}
}