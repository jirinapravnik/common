<?php

/**
 * Bs3FormRenderer
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */

namespace JiriNapravnik\Form;


use Nette;
use Nette\Forms\Controls;
use Nette\Forms\Form;
use Nette\Forms\Rendering\DefaultFormRenderer;
/**
 * FormRenderer for Bootstrap 4 framework.
 */
class Bs4FormRendererBase extends DefaultFormRenderer
{
	/** @var Controls\Button */
	public $primaryButton;
	/** @var bool */
	private $controlsInit = false;
	/** @var string */
	private $layout;
	public function __construct($layout = 'horizontal')
	{
		$this->layout = $layout;
		$groupClasses = 'form-group';
		if ($layout === 'horizontal') {
			$groupClasses .= ' row';
		} elseif ($layout === 'inline') {
			$groupClasses .= ' mb-2 mr-sm-2';
		}
		$this->wrappers['controls']['container'] = null;
		$this->wrappers['pair']['container'] = 'div class="' . $groupClasses . '"';
		$this->wrappers['control']['container'] = $layout == 'horizontal' ? 'div class=col-sm-9' : null;
		$this->wrappers['label']['container'] = $layout == 'horizontal' ? 'div class="col-sm-3 col-form-label"' : null;
		$this->wrappers['control']['description'] = 'small class="form-text text-muted"';
		$this->wrappers['control']['errorcontainer'] = 'div class=invalid-feedback';
		$this->wrappers['control']['.error'] = 'is-invalid';
		$this->wrappers['control']['.file'] = 'form-file';
		$this->wrappers['error']['container'] = null;
		$this->wrappers['error']['item'] = 'div class="alert alert-danger" role=alert';
		if ($layout === 'inline') {
			$this->wrappers['group']['container'] = null;
			$this->wrappers['group']['label'] = 'h2';
		}
	}
	public function renderBegin(): string
	{
		$this->controlsInit();
		return parent::renderBegin();
	}
	public function renderEnd(): string
	{
		$this->controlsInit();
		return parent::renderEnd();
	}
	public function renderBody(): string
	{
		$this->controlsInit();
		return parent::renderBody();
	}
	public function renderControls($parent): string
	{
		$this->controlsInit();
		return parent::renderControls($parent);
	}
	public function renderPair(Nette\Forms\IControl $control): string
	{
		$this->controlsInit();
		return parent::renderPair($control);
	}
	public function renderPairMulti(array $controls): string
	{
		$this->controlsInit();
		return parent::renderPairMulti($controls);
	}
	public function renderLabel(Nette\Forms\IControl $control): Nette\Utils\Html
	{
		$this->controlsInit();
		return parent::renderLabel($control);
	}
	public function renderControl(Nette\Forms\IControl $control): Nette\Utils\Html
	{
		$this->controlsInit();
		return parent::renderControl($control);
	}
	private function controlsInit()
	{
		if ($this->controlsInit) {
			return;
		}
		$this->controlsInit = true;
		if ($this->layout == 'inline') {
			$this->form->getElementPrototype()->addClass('form-inline');
		}
		foreach ($this->form->getControls() as $control) {
			// TODO: remove after https://github.com/nette/forms/pull/209 is available
			$control->getControlPrototype()->class($this->getValue('control .error'), $control->hasErrors());
			if ($this->layout === 'inline' && !$control instanceof Controls\Checkbox) {
				$control->getLabelPrototype()->addClass('my-1')->addClass('mr-2');
			}
			if ($control instanceof Controls\Button) {
				$markAsPrimary = $control === $this->primaryButton || (!isset($this->primaryButton) && empty($usedPrimary) && $control->parent instanceof Form);
				if ($markAsPrimary) {
					$class = 'btn btn-primary';
					$usedPrimary = true;
				} else {
					$class = 'btn btn-secondary';
				}
				$control->getControlPrototype()->addClass($class);
			} elseif ($control instanceof Controls\TextBase || $control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox) {
				$control->getControlPrototype()->addClass('form-control');
			} elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList) {
				$control->getControlPrototype()->addClass('form-check-input');
				$control->getSeparatorPrototype()->setName('div')->addClass('form-check')->class('form-check-inline', $this->layout == 'inline');
				if ($control instanceof Controls\Checkbox) {
					$control->getLabelPrototype()->addClass('form-check-label');
				} else {
					$control->getItemLabelPrototype()->addClass('form-check-label');
				}
			}
		}
	}
}
