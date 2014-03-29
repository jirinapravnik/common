<?php

namespace JiriNapravnik\WebLoader\Filter;

use WebLoader\Compiler;

/**
 * @author Dusan Hudak <admin@dusan-hudak.com>
 */
class LessFilter
{
	/** @var  \Less_Parser */
	private $parser;


	/**
	 * @param \Less_Parser $parser
	 */
	public function __construct(\Less_Parser $parser = NULL)
	{
		$this->parser = new \Less_Parser();
	}


	/**
	 * @return \Less_Parser
	 */
	private function getLessC()
	{
		// lazy loading
		if (empty($this->parser)) {
			$this->parser = new \Less_Parser();
		}

		return $this->parser;
	}


	/**
	 * Invoke filter
	 * @param string $code
	 * @param \WebLoader\Compiler $loader
	 * @param string $file
	 * @return string
	 */
	public function __invoke($code, Compiler $loader, $file)
	{
		if (pathinfo($file, PATHINFO_EXTENSION) === 'less') {
			$this->getLessC()->parseFile($file);
			return $this->getLessC()->getCss();
		}

		return $code;
	}
}