<?php
require_once('../htdocs/core/Ka.php');

$app = Ka::getInstance();

$app->heap['DOCUMENT_ROOT'] = '/data/sites/kino.loc/htdocs';

$app->registerAutoload('lib','app/controller','core','core/api','core/operators');

$cli = $app->router('cli');

print '<pre>'.print_r($cli->option(''),true).'</pre>';