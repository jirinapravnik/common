<?php

namespace JiriNapravnik\Component\FormErrors;

interface IFormErrorsFactory
{
	/**
	 * @return FormErrors
	 */
	function create($form, $cleanErrors = TRUE);
}