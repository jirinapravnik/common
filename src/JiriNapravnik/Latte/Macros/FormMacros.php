<?php

namespace JiriNapravnik\Latte\Macros;

use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;

/*
 * Macros for latte
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */

class FormMacros extends MacroSet
{

	public static function install(Compiler $compiler)
	{
		$set = new static($compiler);
		$set->addMacro('form', array($set, 'macroFormBegin'), array($set, 'macroFormEnd'));
		$set->addMacro('pair', array($set, 'macroPair'));
		$set->addMacro('label', array($set, 'macroLabel'));
		$set->addMacro('container', array($set, 'macroContainer'));
	}

	/**
	 * {label ...} and optionally {/label}
	 * With css class 'required'
	 */
	public function macroLabel(MacroNode $node, PhpWriter $writer)
	{
		$cmd = '
      $_input = is_object(%node.word) ? %node.word : $_form[%node.word];
      $attributes = %node.array;
      if ($_input->required) {
        $attributes += array("class" => "required");
      }
      if ($_label = $_input->getLabel())
        echo $_label->addAttributes($attributes)';  // ->startTag() may be appended to the string so don't end with } or ;
		if ($node->isEmpty = (substr($node->args, -1) === '/')) {  // {label xyz /}
			$node->setArgs(substr($node->args, 0, -1));
			return $writer->write($cmd);
		} else {												   // {label xyz} abc {/label}
			return $writer->write($cmd . '->startTag()');
		}
	}

	public function macroFormBegin(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('if(!class_exists(\'Nette\Bridges\FormsLatte\FormMacros\')) class_alias(\'Nette\Bridges\FormsLatte\FormMacros\', \'Nette\Latte\Macros\FormMacros\');'
				. '$form = $__form = $_form = (is_object(%node.word) ? %node.word : $_control->getComponent(%node.word)); Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($__form, %node.array);');
	}

	public function macroFormEnd(MacroNode $node, PhpWriter $writer)
	{

		return $writer->write('if(!class_exists(\'Nette\Bridges\FormsLatte\FormMacros\'))class_alias(\'Nette\Bridges\FormsLatte\FormMacros\', \'Nette\Latte\Macros\FormMacros\');'
				. 'Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($__form)');
	}

	public function macroPair(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('$_form->render(\'pair\', $_form[%node.word])');
	}

	public function macroContainer(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('$_form->render(\'container\', $_form[%node.word])');
	}

}
