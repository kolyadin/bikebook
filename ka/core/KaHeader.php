<?php
class KaHeader
{
	private $app;

	public function __construct(Ka $app)
	{
		$this->app = $app;
	}

	public function location($url)
	{
		header('Location:'.$url,true,301);
		die;
	}
	
	public function statusCode($codeNumber)
	{
		switch ($codeNumber)
		{
			case 404:
				header('HTTP/1.0 404 Not Found');
				break;
		}
	}
}
