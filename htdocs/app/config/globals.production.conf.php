<?php
$config = array();

$config['mysqli'] = array(
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '123',
	'dbname'   => 'bikebook',
	'port'     => null,
	'socket'   => null
);

$config['mongo'] = array(
	 'server'  => 'mongodb://localhost:27017'
	,'options' => array()
	,'db'      => 'bikebook'
);

$config['bin'] = array(
	 'bash'     => '/bin/bash'
	,'convert'  => '/usr/bin/convert'
	,'identify' => '/usr/bin/identify'
	,'lock'     => '/usr/bin/flock -n'
);

$config['staticServers'] = array(
	 'v0.kinoafisha.org' => array('hitRate' => '80%', 'skip' => true)
	,'v2.kinoafisha.org' => array('hitRate' => '20%')
);

$config['memcacheSocket'] = '///var/run/memcache.sock';

$config['PROJECT_ROOT']   = '/data/sites/bikebook.loc';
$config['DOCUMENT_ROOT']  = $config['PROJECT_ROOT'] . '/htdocs';

$config['controllerPath'] = $config['DOCUMENT_ROOT'] . '/app/controller';
$config['viewPath']       = $config['DOCUMENT_ROOT'] . '/app/view';
$config['modelPath']      = $config['DOCUMENT_ROOT'] . '/app/model';
$config['libPath']        = $config['PROJECT_ROOT']  . '/lib';
$config['sqlPath']        = $config['DOCUMENT_ROOT'] . '/app/config/sql';
$config['picPath']        = $config['DOCUMENT_ROOT'] . '/k';
$config['logPath']        = $config['PROJECT_ROOT']  . '/data/log';


$config['upload']         = $config['DOCUMENT_ROOT'] . '/upload';
$config['tmp']            = '/tmp';


return $config;