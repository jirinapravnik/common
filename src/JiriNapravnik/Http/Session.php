<?php
namespace JiriNapravnik\Http;

class Session extends \Nette\Http\Session
{
	public function regenerateId()
	{
		return;		
	}
}
