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

class CommonMacros extends MacroSet
{

	public static function install(Compiler $compiler)
	{
		$set = new static($compiler);
		$set->addMacro('confirm', NULL, NULL, array($set, 'macroConfirm'));
		$set->addMacro('confirmModal', NULL, NULL, array($set, 'macroConfirmModal'));
	}
	
	/**
	 * n:confirm="..."
	 */
	public function macroConfirm(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('echo \' data-confirm="\' . %escape("' . $node->args . '") . \'"\' ');
	}

	/**
	 * n:confirmModal="..."
	 */
	public function macroConfirmModal(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('echo \' data-confirm="modal" data-confirm-text="\' . %escape("' . $node->args . '") . \'"\' ');
	}
}
