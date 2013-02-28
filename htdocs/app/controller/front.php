<?php
class front extends KaController
{
	public function __construct()
	{
		#print $this->app->user()->who();

	}

	public function fill()
	{

	}

    public function indexPage()
    {
		$foto1 = $this->app->resizer()->resize('/upload/d5/e0/a1/c.jpg','{"w":120,"z":"1"}');



		/*
		$foto2 = $this->app->resizer()->resize('/upload/d5/e0/a1/c.jpg','{"w":121,"z":5}');
		$foto3 = $this->app->resizer()->resize('/upload/d5/e0/a1/c.jpg','{"w":122,"z":5}');
		$foto4 = $this->app->resizer()->resize('/upload/d5/e0/a1/c.jpg','{"w":123,"z":5}');
		$foto5 = $this->app->resizer()->resize('/upload/d5/e0/a1/c.jpg','{"w":124,"z":5}');
		*/

		$this->view->display('index_page.twig',array(
			'foto' => "<p><img src=\"$foto1\" />"
		));
    }
}