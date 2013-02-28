<?php
class KAExceptionDB extends Exception
{
	public function __construct($errorMsg, $errorCode = false, $sendMail = false)
	{
		if ($sendMail)
		{
			$this->sendmail();
		}
		
		parent::__construct($errorMsg,$errorCode);
	}
	
	private function sendmail()
	{
		print 'email sent';
	}
}
