<?php

namespace JiriNapravnik\Components\FormErrors;

interface IFormErrorsFactory
{
	/**
	 * @return FormErrors
	 */
	function create($form, $cleanErrors = TRUE);
}