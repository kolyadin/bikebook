<?php
ini_set('display_errors',1);
error_reporting(E_ALL);


exec('/usr/bin/convert /data/sites/bikebook.loc/htdocs/upload/d5/e0/a1/c.jpg -resize "300x" /data/sites/bikebook.loc/htdocs/k2/c.200.jpg 2>&1',$output);

if ()

print '<pre>'.print_r($output,true).'</pre>';



__halt_compiler();
require_once('../ka/autoload.php');

$app = Ka::fastBoot('production','app/config/globals.%s.conf.php');

printf('<p><img src="%s" />'."\n"
	,$app->resizer()->resize('/upload/d5/e0/a1/c.jpg','{"w":100,"v":"'.microtime().'"}')
);





print '<pre>'.print_r($app->stopwatch,true).'</pre>';