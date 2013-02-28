<?php
$searchDirs = array('core/','core/api/','core/operators/');

spl_autoload_register(function($className) use($searchDirs) {
	foreach ($searchDirs as $dir)
	{
		$currentDirectory = rtrim(dirname(__FILE__).'/'.$dir,'/');
		$checkFile = $currentDirectory.'/'.$className.'.php';

		if (file_exists($checkFile))
		{
			require_once($checkFile);
			break;
		}
	}
});