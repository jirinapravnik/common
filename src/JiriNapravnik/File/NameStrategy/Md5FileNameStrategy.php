<?php

namespace JiriNapravnik\File\NameStrategy;
use Nette\Utils\Strings;

/**
 * class for uploading files, making dirs etc.
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2007, Jiří Nápravník
 */
class Md5FileNameStrategy
{

	private $newFileName;

	public function __construct($mainDirectory, $originalName, $depth = 2)
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

		$md5Name = Strings::substring(md5($originalName), 0, 10);

		for($i = 0; $i < $depth; $i++){
		    $actDir .= Strings::substring($md5Name, $i * 2, 2) . '/';
        }

        if (!is_dir($actDir)) {
            mkdir($actDir, 0777, TRUE);
            chmod($actDir, 0777);
        }

		$explOriginal = explode(DIRECTORY_SEPARATOR, $originalName);
		$expl = explode('.', $explOriginal[count($explOriginal) - 1]);

		$fileName = $md5Name . '-';
        for ($i = 0; $i < count($expl) - 1; $i++) {
            $fileName .= $expl[$i];
            if($i != count($expl) - 2){
                $fileName .= '-';
            }
        }
        $fileName .= '.' . $expl[count($expl) - 1];

		$this->newFileName = $actDir . strtolower($fileName);
	}

	public function getNewFileName()
	{
		return $this->newFileName;
	}

}
