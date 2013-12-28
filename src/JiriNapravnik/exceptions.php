<?php
namespace JiriNapravnik;

/**
 * exceptions
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2013, Jiří Nápravník
 */
class NotImplementedException extends \LogicException
{
	
}

class RecordNotFoundException extends \RuntimeException
{
	
}

class InvalidStateException extends \RuntimeException
{
	
}

class InvalidArgumentException extends \InvalidArgumentException
{
	
}
