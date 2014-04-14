<?php

namespace JiriNapravnik\WebLoader\Filter;

use WebLoader\Compiler;

class CssMinFilter
{

	public function __invoke($code)
	{
//		$code = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $code);
//		$code = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $code);
//		$code = str_replace('{ ', '{', $code);
//		$code = str_replace(' }', '}', $code);
//		$code = str_replace('; ', ';', $code);
//
//		return $code;
		return \CssMin::minify($code);
	}

}
