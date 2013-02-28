<?php
require_once('lib/KAException.php');

KAException::$debugMode = true;
KAException::setupEnvironment();

session_name('made_by_Kolyadin_Aleksey');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	require_once('lib/KADB.php');
	
	$mysqli = KADB::getInstance();
	
	$email = $_POST['email'];
	$pwd   = $_POST['pwd'];
	
	$result = $mysqli->query(sprintf('SELECT id, _pwd_hash, _salt, _auth_hash FROM ka_user WHERE email = "%s" LIMIT 1'
		,$mysqli->real_escape_string($email)
	));
	
	list($userID,$pwdHash,$salt,$authHash) = $result->fetch_row();
	
	require_once('lib/Bcrypt.php');
	
	$bcrypt = new Bcrypt(11);
	
	if ($bcrypt->verify($email.$pwd.$salt,$pwdHash))
	{
		$mysqli->query(sprintf('INSERT INTO ka_user_session SET user_id = %u, auth_time = %u, ip = "%s", user_agent = "%s"'
			,$userID
			,time()
			,$_SERVER['REMOTE_ADDR']
			,$mysqli->real_escape_string($_SERVER['HTTP_USER_AGENT'])
		));
		
		setcookie('ka_user_auth', $authHash, strtotime('+1 year'), '/', '.test1.loc');
		
		header('Location:/login.php');
	}
	else
	{
		print "wrong<br/>\n";
		echo '<pre>'.print_r(array('pwd'=>$pwd,'salt'=>$salt,'hash'=>$pwdHash),1).'</pre>';
	}
}
?>

<form action="/login.php" method="post">
	<p>Мыло:<br/>
	<input name="email" />
	
	<p>Пароль:<br/>
	<input type="password" name="pwd" />
	
	<p><input type="submit" value="Вперед" />
</form>
