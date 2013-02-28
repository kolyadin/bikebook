<?php
require_once('../ka/autoload.php');

$app = Ka::fastBoot();

$resizer = $app->resizer();

if (isset($_GET['fileMode']) && $_GET['fileMode'] == 1)
{
	/*
	$tryFile = $app->config()->globals['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'];

	$mongo = $this->app->mongo();

	$fileExists = $mongo->pic_gen->find(array(
		'source_file'   => $file['sourceRel']
		,'file'         => $file['newRel']
		,'options_hash' => md5($options)
	)->count() == 1) ? true : false;
	*/

	#print 13;

	#die;
}

#print '<pre>'.print_r($_SERVER,true).'</pre>';
#print '<pre>'.print_r($_GET,true).'</pre>';

for ($i=0;$i<=200000;$i++)
{
	printf('<p><img src="%s" />'."\n"
		,$resizer->resize('/upload/d5/e0/a1/c.jpg','{"w":100,"v":"'.microtime(1).'"}')
	);
}



#echo '<br/>',$app->genTime();