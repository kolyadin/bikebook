<?php
class KaSystem extends KaController
{
	public function __construct()
	{
	}

	public function dispatcher()
	{
		$this->view->display('auth.twig');
	}
}