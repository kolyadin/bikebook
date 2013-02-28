<?php
class sos extends KaController
{
	public function __construct()
	{
	}

	public function indexPage()
	{
		$this->view->display('sos.twig');
	}
}