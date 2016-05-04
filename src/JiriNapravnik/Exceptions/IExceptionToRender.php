<?php

/**
 * RenderableException
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2014, Jiří Nápravník
 */

namespace JiriNapravnik\Exceptions;

interface IExceptionToRender
{
    public function getMessageToRender($linkGenerator);
}