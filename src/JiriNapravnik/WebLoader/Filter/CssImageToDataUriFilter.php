<?php

namespace JiriNapravnik\WebLoader\Filter;

class CssImageToDataUriFilter
{

	public function __invoke($code)
	{
		// thanks to kravco
		$regexp = '~
			(?<![a-z])
			url\(                                     ## url(
				\s*                                   ##   optional whitespace
				([\'"])?                              ##   optional single/double quote
				(   (?: (?:\\\\.)+                    ##     escape sequences
					|   [^\'"\\\\,()\s]+              ##     safe characters
					|   (?(1)   (?!\1)[\'"\\\\,() \t] ##       allowed special characters
						|       ^                     ##       (none, if not quoted)
						)
					)*                                ##     (greedy match)
				)
				(?(1)\1)                              ##   optional single/double quote
				\s*                                   ##   optional whitespace
			\)                                        ## )
		~xs';

		$self = $this;

		return preg_replace_callback($regexp, function ($matches) use ($self) {

			$image = trim($matches[2], '/');

			if (file_exists($image) && filesize($image) < 20000) {
				$imageSize = getimagesize($image);

				$imageData = base64_encode(file_get_contents($image));

				return "url('data: " . $imageSize['mime'] . ";base64," . $imageData . "')";
			} else {
				return "url('" . $matches[2] . "')";
			}
		}, $code);
	}

}
