<?php

namespace JiriNapravnik\WebLoader\Filter;

class JsMinFilter
{

	public function __invoke($code)
	{
		return \JShrink\Minifier::minify($code);
	}

}
