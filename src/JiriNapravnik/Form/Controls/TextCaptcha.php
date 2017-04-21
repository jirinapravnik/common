<?php

namespace JiriNapravnik\Form\Controls;

use Nette\Environment;
use Nette\Forms\Controls\TextBase;
use Nette\Forms\Form;
use Nette\Utils\Html;

class TextCaptcha extends TextBase
{

	private $questions = [
		['question' => 'Kolik má člověk nohou? (napište číslo)', 'answer' => 2],
		['question' => 'Kolik má pes nohou? (napište číslo)', 'answer' => 4],
		['question' => 'Které slovo nepatří mezi ostatní: banán, auto, pomeranč', 'answer' => 'auto'],
		['question' => 'Kolik je 5 + 5? (napište SLOVEM)', 'answer' => 'deset'],
	];
	private $session;
	private $sessionSection;
	
	public function setSession($session){
		$this->session = $session;
	}
	
	protected function attached($form)
	{
		parent::attached($form);
		
		$this->sessionSection = $sessionSection = $this->getName() . 'textCaptcha';
		
		if($this->session->hasSection($sessionSection) && isset($this->session->getSection($sessionSection)->questionId)){
			$questionId = $this->session->getSection($sessionSection)->questionId;
		} else {
			$this->session->getSection($sessionSection)->questionId = $questionId = rand(0, count($this->questions) - 1);
		}
		
		$this->setRequired();
		$this->addRule(Form::EQUAL, 'Neodpověděl(a) jste správně na otázku.', $this->questions[$questionId]['answer']);
	}
	
	public function getControl()
	{
		$el = parent::getControl();
		
		$questionId = $this->session->getSection($this->sessionSection)->questionId;
		if(isset($this->questions[$questionId]['question'])){
			$label = $this->questions[$questionId]['question'];
		} else {
			$label = '';
		}
		return Html::el('label')->setText($label)->addHtml($el);
	}
	
	public function validate()
	{
		parent::validate();
		
		if($this->getRules()->validate() === TRUE){
			$this->session->getSection($this->sessionSection)->remove();
		}
	}

}
