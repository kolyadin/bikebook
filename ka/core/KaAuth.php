<?php
class KaAuth
{
	private $isAuthorized = false;
	public $userData = array();
	
	private $app;

	private static $instance = null;

	public static function getInstance(Ka $app)
	{
		if (self::$instance == null)
		{
			self::$instance = new self($app);
		}

		return self::$instance;
	}

	public function __construct(Ka $app)
	{
		$this->app = $app;
	}

	public function isAuthorized()
	{
		if ($this->isAuthorized) return true;

		if (isset($_COOKIE['ka_user_auth']) && !empty($_COOKIE['ka_user_auth']) && strpos($_COOKIE['ka_user_auth'],'|') !== false)
		{
			list($userID,$authHash) = explode('|',$_COOKIE['ka_user_auth']);
			
			$result = $this->app->mysqli()->query(sprintf('SELECT HIGH_PRIORITY * FROM ka_user USE KEY (key_auth) WHERE id = %u AND _auth_hash = "%s" LIMIT 1'
				,$userID
				,$this->app->mysqli()->escape($authHash)
			));
			
			if ($result->num_rows == 1)
			{
				$this->isAuthorized = true;
				$this->userData = $result->fetch_assoc();
				
				$this->userData['exitHash'] = sha1($this->userData['email'].$this->userData['_auth_hash']);

				$this->app->user()->data =& $this->userData;
				
				return true;
			}
			
			return false;
		}
		
		return false;
	}
	
	public function logOut($securityHash)
	{
		if (!$this->isAuthorized()) throw new KaException('Пользователь не авторизован',401);

		$mysqli = $this->app->mysqli();
		
		$result = $mysqli->squery('SELECT 1 FROM ka_user WHERE id = %u AND SHA1(CONCAT(email,_auth_hash)) = "%s" LIMIT 1'
			,$this->userData['id']
			,$mysqli->escape($securityHash)
		);
		
		if ($result->num_rows != 1) throw new KaException('Указан неверный хэш безопасности',402);
		
		$authHash = $mysqli->generateUniqueHashByField('ka_user','_auth_hash');
		
		$result = $mysqli->query(sprintf('UPDATE ka_user SET _auth_hash = "%s" WHERE id = %u'
			,$mysqli->escape($authHash)
			,$this->userData['id']
		));
		
		$this->isAuthorized = false;

		setcookie('ka_user_auth',-1,time()-3600,'/');
		
		return true;
	}
	
	public function proceed($email,$pwd)
	{
		$mysqli = $this->app->mysqli();

		$result = $mysqli->squery('SELECT id, _pwd_hash, _salt FROM ka_user WHERE email = "%s" LIMIT 1'
			,$mysqli->real_escape_string($email)
		);
		
		if (!$result->num_rows) throw new KaException(sprintf('Указан пользователь с несуществующей электропочтой [%s]',$email),401);
		
		list($userID,$pwdHash,$salt) = $result->fetch_row();
		$result->free();
		
		$authHash = $mysqli->generateUniqueHashByField('ka_user','_auth_hash');
		
		$result = $mysqli->query(sprintf('UPDATE ka_user SET _auth_hash = "%s" WHERE id = %u'
			,$mysqli->escape($authHash)
			,$userID
		));

		require_once($this->app->config()->globals['libPath'].'/Bcrypt.php');

		$bcrypt = new Bcrypt(11);
		
		if ($bcrypt->verify($email.$pwd.$salt,$pwdHash))
		{
			$mysqli->query(sprintf('INSERT INTO ka_user_session SET user_id = %u, auth_time = %u, ip = "%s", user_agent = "%s"'
				,$userID
				,time()
				,$_SERVER['REMOTE_ADDR']
				,$mysqli->escape($_SERVER['HTTP_USER_AGENT'])
			));
			
			$this->isAuthorized = true;
			
			return $userID.'|'.$authHash;
		}
		else
		{
			throw new KaException('Пароль не подходит',402);
		}
	}
}
