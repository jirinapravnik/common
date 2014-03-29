<?php

namespace JiriNapravnik\Components\FlashMessage;

interface IFlashMessageFactory
{
	/**
	 * @return FlashMessage
	 */
	function create();
}