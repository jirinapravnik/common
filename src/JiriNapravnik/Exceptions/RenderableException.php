<?php

/**
 * RenderableException
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2014, Jiří Nápravník
 */

namespace JiriNapravnik\Exception;

trait RenderableException
{
    public $count;
    public $parameters;
    public $domain = 'front';

    public function renderMessage(Kdyby\Translation\Translator $translator)
    {
        $message = ClassType::from($this)->getShortName() . '.' . $this->code;
        return $this->translator->translate($message, $this->count, $this->parameters, $this->domain);
    }
}