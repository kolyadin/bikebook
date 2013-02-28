<?php
require_once('/data/sites/test1.loc/htdocs/core/KADB.php');

$mysqli = KADB::getInstance();

require_once('/data/sites/test1.loc/htdocs/lib/Bcrypt.php');

$bcrypt = new Bcrypt(4);

for ($i=0;$i<=100000;$i++)
{
	$pwd   = uniqid();
	$email = rand(111111,999999).uniqid().'@gmail.com';
	
	$salt     = KADB::generateHash(10,20);
	$authHash = KADB::generateUniqueHashByField('ka_user','_auth_hash');
	
	$pwdHash = $bcrypt->hash($email.$pwd.$salt);
	
	$mysqli->query(sprintf('INSERT DELAYED INTO ka_user SET email = "%s", _pwd_hash = "%s", _salt = "%s", _auth_hash = "%s"'
		,$mysqli->real_escape_string($email)
		,$pwdHash
		,$salt
		,$authHash
	));
	
	#if ($mysqli->error) die($mysqli->error);
	
	unset($pwd,$email,$salt,$authHash,$pwdHash);
	
	if (($i%100)==0) print "$i\n";
}
