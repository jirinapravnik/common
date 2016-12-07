<?php

namespace JiriNapravnik\Latte\Macros;

use Latte\CompileException;
use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;
use Nette\Forms\Controls\BaseControl;
use Nette\Utils\Html;

/*
 * Macros for latte
 * inspired by nextras/forms baseinputmacros
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */

class FormMacros extends MacroSet
{

	public static function install(Compiler $compiler)
	{
		$set = new static($compiler);
//		$set->addMacro('form', array($set, 'macroFormBegin'), array($set, 'macroFormEnd'));
		$set->addMacro('pair', array($set, 'macroPair'));
		$set->addMacro('label', array($set, 'macroLabel'), array($set, 'macroLabelEnd'));
		$set->addMacro('container', array($set, 'macroContainer'));
	}

	/**
	 * {label ...} and optionally {/label}
	 * With css class 'required'
	 */
	public function macroLabel(MacroNode $node, PhpWriter $writer)
	{
		$class = get_class($this);
		$words = $node->tokenizer->fetchWords();
		if (!$words) {
			throw new CompileException("Missing name in {{$node->name}}.");
		}
		$name = array_shift($words);
		
		return $writer->write(
			($name[0] === '$'
				? '$_input = is_object(%0.word) ? %0.word : $_form[%0.word];'
				: '$_input = $_form[%0.word];'
			) . ''
			. '$attributes = %node.array;
			  if ($_input->required && %2.var === false) {
				$attributes += array("class" => "required");
		      }'
			. 'if ($_label = $_input->%1.raw) echo ' . $class . '::label($_label->addAttributes($attributes), $_input, %2.var)',
			$name,
			$words ? ('getLabelPart(' . implode(', ', array_map(array($writer, 'formatWord'), $words)) . ')') : 'getLabel()',
			(bool) $words
		);
	}
	
	/**
	 * {/label}
	 */
	public function macroLabelEnd(MacroNode $node, PhpWriter $writer)
	{
		if ($node->content != NULL) {
			$node->openingCode = rtrim($node->openingCode, '?> ') . '->startTag() ?>';
			return $writer->write('if ($_label) echo $_label->endTag()');
		}
	}
	
	public static function label(Html $label, BaseControl $control, $isPart)
	{
		return $label;
	}

	public function macroFormBegin(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('$echo = TRUE; if(!class_exists(\'Nette\Bridges\FormsLatte\Runtime\')){ class_alias(\'Nette\Bridges\FormsLatte\Runtime\', \'Nette\Bridges\FormsLatte\FormMacros\'); $echo = FALSE;}'
				. '$form = $__form = $_form = (is_object(%node.word) ? %node.word : $_control->getComponent(%node.word)); $out = Nette\Bridges\FormsLatte\Runtime::renderFormBegin($__form, %node.array);  if($echo) echo $out;');
	}

	public function macroFormEnd(MacroNode $node, PhpWriter $writer)
	{

		return $writer->write('$echo = TRUE; if(!class_exists(\'Nette\Bridges\FormsLatte\Runtime\')){class_alias(\'Nette\Bridges\FormsLatte\Runtime\', \'Nette\Bridges\FormsLatte\FormMacros\'); $echo = FALSE; }'
				. '$out = Nette\Bridges\FormsLatte\Runtime::renderFormEnd($__form); if($echo) echo $out;');
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
