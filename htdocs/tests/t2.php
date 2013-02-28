<?php
require_once('lib/KAException.php');

KAException::$debugMode = true;
KAException::setupEnvironment();

session_name('made_by_Kolyadin_Aleksey');
session_start();

$_SESSION['testdata'][] = uniqid();

echo '<pre>'.print_r($_COOKIE,1).'</pre>';
echo '<pre>'.print_r($_SESSION,1).'</pre>';

require_once('lib/KADB.php');

$mysqli = KADB::getInstance();

require_once('lib/Bcrypt.php');



#$bcrypt = new Bcrypt(11);

/*
$data = array();

$data['password'] = 'hFvGTE5Gp';
$data['hash1'] = $bcrypt->hash($data['password']);
$data['salt'] = substr($data['hash1'],-10);
$data['hash2'] = $bcrypt->hash($data['password'].$data['salt']);
$data['verify'] = $bcrypt->verify($data['password'], $data['hash1']);

echo '<pre>'.print_r($data,1).'</pre>';
*/

/*
for ($i=0;$i<=100;$i++)
{
	$mysqli->query(sprintf('INSERT INTO ka_users SET email = "%s", security_hash = "%s", auth_hash = "%s"'
		,rand(111111,999999).'@gmail.com'
		,$bcrypt->hash(uniqid())
		,md5(uniqid())
	));
}
*/
#$isGood = $bcrypt->verify('password', $hash);
