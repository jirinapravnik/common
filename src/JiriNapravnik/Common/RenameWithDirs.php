<?php

namespace JiriNapravnik\Common;

/**
 * class for uploading files, making dirs etc.
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2007, Jiří Nápravník
 */
class RenameWithDirs
{

	private $newFileName;

	public function __construct($mainDirectory, $originalName, $structure = TRUE, $fixNewName = null)
	{
		if (!(is_string($originalName) && strlen($originalName) > 0)) {
			return;
		}
		
		if(!is_dir($mainDirectory)){
			mkdir($mainDirectory, 0777, TRUE);
		}
		
		if(!is_writable($mainDirectory)){
			chmod($mainDirectory, 0777);
		}

		$actDir = $mainDirectory;

		if ($structure === TRUE) {
			$date = date('Y/m/d');

			if (!is_dir($actDir = $mainDirectory . $date)) {
				mkdir($actDir, 0777, TRUE);
				chmod($actDir, 0777);
			}
		}

		$explOriginal = explode(DIRECTORY_SEPARATOR, $originalName);
		$expl = explode('.', $explOriginal[count($explOriginal) - 1]);

		$fileName = '';
		if (is_NULL($fixNewName)) {
			for ($i = 0; $i < count($expl) - 1; $i++) {
				$fileName .= $expl[$i] . '-';
			}
			$fileName .= str_shuffle(substr(md5(rand(0, time())), 0, 10));
		} else {
			$fileName = $fixNewName;
		}

		$fileName .= '.' . $expl[count($expl) - 1];

		$this->newFileName = $actDir . strtolower($fileName);
	}

	public function getNewFileName()
	{
		return $this->newFileName;
	}

}
