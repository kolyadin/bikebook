<?php
final class KaException extends Exception
{
	public function __construct($errorMsg, $errorCode = false, $sendMail = false)
	{
		parent::__construct($errorMsg,$errorCode);
	}
	
	/*
	public static function autoload($class)
	{
		if (strpos($class, 'KAException') !== 0)
		{
			return false;
		}
		
		$filePath = dirname(__FILE__).'lib/'.$class.'.php';
		
		if (!is_readable($filePath))
		{
			return false;
		}
		
		require $filePath;
		return true;
	}
	*/
}

#spl_autoload_register('KAException::autoload');
