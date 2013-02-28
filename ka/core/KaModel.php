<?php
class KaModel
{
	public function load($model)
	{
		$path = KaConfig::$DOCUMENT_ROOT.'/app/model'.$model;

		$pp = pathinfo($path);

		require_once(KaConfig::$DOCUMENT_ROOT.'/app/model'.$model);

		$controllerName = 'KaModel'.ucfirst($pp['filename']);
		
		return new $controllerName();
	}

	public function __get($name)
	{
		switch ($name)
		{
			case 'mysqli' : return KaDB::getInstance(); break;
		}
	}
}
