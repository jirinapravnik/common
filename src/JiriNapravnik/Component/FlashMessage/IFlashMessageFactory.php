<?php

namespace JiriNapravnik\Component\FlashMessage;

interface IFlashMessageFactory
{
	/**
	 * @return FlashMessage
	 */
	function create();
}