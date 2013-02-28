<?php
require_once('lib/KAException.php');

KAException::$debugMode = true;
KAException::setupEnvironment();

session_name('made_by_Kolyadin_Aleksey');
session_start();

function idHash()
{
	$minLength = 50;
	$maxLength = 100;
	
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$specchars = '!@#$%().-_';
	
	$str = '';
	
	for ($i=1;$i<=rand($minLength,$maxLength);$i++)
	{
		if (rand(1,6) == 6)
		{
			$str .= $specchars{rand(0,strlen($specchars))};
		}
		else
		{
			$str .= $chars{rand(0,strlen($chars))};
		}
	}
	
	return $str;
}

require_once('lib/KADB.php');

$mysqli = KADB::getInstance();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	require_once('lib/Bcrypt.php');
	
	$bcrypt = new Bcrypt(11);
	
	$pwd   = $_POST['pwd'];
	$email = $_POST['email'];
	
	$salt     = KADB::generateHash(10,20);
	$authHash = KADB::generateUniqueHashByField('ka_user','_auth_hash');
	
	$pwdHash = $bcrypt->hash($email.$pwd.$salt);
	
	$mysqli->query(sprintf('INSERT INTO ka_user SET email = "%s", _pwd_hash = "%s", _salt = "%s", _auth_hash = "%s"'
		,$mysqli->real_escape_string($email)
		,$pwdHash
		,$salt
		,$authHash
	));
	
	header('Location:/reg.php');
	die;
}
?>

<form action="/reg.php" method="post">
	<p>E-mail:<br/>
	<input name="email" />
	
	<p>Пароль:<br/>
	<input type="password" name="pwd" />
	
	<p><input type="submit" value="Вперед" />
</form>
