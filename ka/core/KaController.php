<?php
class KaController
{
	public function __construct()
	{

	}

	public function __get($name)
	{
		switch ($name)
		{
			case 'view'   : return Ka::Application()->view(); break;
			case 'model'  : return new KaModel; break;
			case 'helper' : return new KaHelper; break;
			case 'db'     : return Ka::Application()->mysqli(); break;
			case 'app'    : return Ka::Application(); break;
		}
	}
}