<?php
class iResizer
{
	const convertPath = '/usr/bin/convert';
	const identifyPath = '/usr/bin/identify';
	
	const resizeMask = '/k/%options%/%size%';
	const sourcePath = '/upload';
	
	const iResizerTypeResize = 'r';
	const iResizerTypeProportion = 'p';
	const iResizerTypeCrop = 'c';
	
	public function __construct()
	{
		$p = preg_replace('@\/{2,}@','/',$_SERVER['REQUEST_URI']);
		
		$paths = array();
		
		foreach (explode('/',$p) as $s)
		{
			if (empty($s) && $s != '0') continue;
			$paths[] = strtolower($s);
		}
		
		if (count($paths) < 3)
		{
			header("HTTP/1.0 404 Not Found");
			die;
		}
		
		$destPath = dirname($_SERVER['DOCUMENT_ROOT'].'/'.implode('/',$paths));
		$destFilePath = $destPath.'/'.end($paths);
		$srcFilePath = $_SERVER['DOCUMENT_ROOT'].'/'.implode('/',array_slice($paths,3));
		
		if (!is_dir($destPath)) mkdir($destPath,0777,true);
		
		$options = $this->parseOptions($paths[1]);
		
		if (in_array(self::iResizerTypeResize,$options))      $command = $paths[2];
		if (!in_array(self::iResizerTypeProportion,$options)) $command .= '!';
		
		exec(sprintf('%s %s -resize "%s" -strip -quality 90 -quiet %s'
			,self::convertPath
			,$srcFilePath
			,$command
			,$destFilePath
		));
		
		exec(sprintf('%s -format "%%m" %s'
			,self::identifyPath
			,$destFilePath
		),$ext);
		
		header('Content-Type: image/'.strtolower($ext[0]));
		die(file_get_contents($destFilePath));
	}
	
	private function parseOptions($mask)
	{
		preg_match_all('@(r|p|w\d*|c)@',$mask,$m);
		
		if (!isset($m[1]) && !count($m[1])) return false;
		
		return $m[1];
	}
	
	public function displayImage()
	{
		
	}
	
	private function parseSize()
	{
		
	}
}

$iResizer = new iResizer;
?>
