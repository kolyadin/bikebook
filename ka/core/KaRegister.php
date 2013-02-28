<?php
class KaRegister
{
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

	public function proceed($data)
	{
		$mysqli = $this->app->mysqli();

		$result = $mysqli->squery('SELECT id, _pwd_hash, _salt FROM ka_user WHERE email = "%s" LIMIT 1'
			,$mysqli->escape($data['email'])
		);

		if ($result->num_rows == 1) throw new KaException(sprintf('Пользователь с такой электропочтой [%s] уже существует',$data['email']),401);

		$result->free();

		require_once($this->app->config()->globals['libPath'].'/Bcrypt.php');

		$bcrypt = new Bcrypt(11);

		$salt     = $mysqli->generateHash(10,20);
		$authHash = $mysqli->generateUniqueHashByField('ka_user','_auth_hash');

		$pwdHash = $bcrypt->hash($data['email'].$data['pwd'].$salt);

		$insertOk = $mysqli->queryFile('/user.sql/new-biker'
			,date('Y-m-d H:i:s')
			,$mysqli->escape($data['email'])
			,'1987-02-13'
			,$mysqli->escape($data['sex'])
			,$pwdHash
			,$salt
			,$authHash
		);

		if (!$insertOk) throw new KaException('Не получается записать нового пользователя в БД');

		$result = $mysqli->squery('SELECT * FROM ka_user WHERE id = %u LIMIT 1', $mysqli->insert_id);

		return $result->fetch_assoc();
	}
}
