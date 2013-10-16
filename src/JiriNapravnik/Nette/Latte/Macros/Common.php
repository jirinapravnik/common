<?php

namespace Enbros\Nette\Latte\Macros;

use \Nette\Latte\MacroNode;
use \Nette\Latte\PhpWriter;

class Common extends \Nette\Latte\Macros\MacroSet
{

    public static function install(\Nette\Latte\Compiler $compiler)
    {
        $set = new static($compiler);
        $set->addMacro('confirm', NULL, NULL, array($set, 'macroConfirm'));
    }

    /**
     * n:confirm="..."
     */
    public function macroConfirm(MacroNode $node, PhpWriter $writer)
    {
        return $writer->write('echo \'data-confirm="\' . %escape("' . $node->args . '") . \'"\' ');
    }

}

