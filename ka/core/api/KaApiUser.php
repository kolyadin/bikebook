<?php
class KaApiUser extends KaApiAbstract
{
	private $table = 'ka_user';
	
	public function getById($fields,$id)
	{
		
	}
	
	public function insertManager()
	{
		return new KaApiUserInsertManager;
	}
}

class KaApiUserException extends Exception
{
	public function __construct($errorMsg, $errorCode = false, $sendMail = false)
	{
		parent::__construct($errorMsg,$errorCode);
	}
}

class KaApiUserInsertManager
{
	private $preSaveCheck = false;
	private $correctFields = array('id','email','dob','city','sex');
	
	private $mysqli;

	public function __construct()
	{
		$this->mysqli = KaDB::getInstance();
	}
	
	/** Метод проверяет правильность данных
		
		Коды ошибок:
		
		301 - Не указан пароль
		302 - Неверный формат электропочты
		303 - Попытка повтора электропочты
		304 - Указан неверный формат даты рождения (опциональный параметр)
		
		@return bool true
	*/
	public function preSave()#{{{
	{
		if (!isset($this->password))
		{
			throw new KaApiUserException('Пароль надо указать обязательно', 301);
		}
		
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
		{
			throw new KaApiUserException('Неправильный формат электропочты', 302);
		}
		
		
		//Проверяем дубль электропочты
		$result = $this->mysqli->query(sprintf('SELECT count(*) FROM ka_user WHERE email = "%s"',$this->email));
		list($exists) = $result->fetch_row();
		
		if ($exists) throw new KaApiUserException(sprintf('Электропочта [%s] уже есть в базе. Дубли электропочты недопустимы',$this->email),303);
		
		
		//Проверяем дату рождения
		if (sscanf($this->dob,'%02u.%02u.%04u',$d,$m,$y) && checkdate($m,$d,$y))
		{
			$this->dobClean = "$y-$m-$d";
		}
		else throw new KaApiUserException('Неправильный формат даты рождения (пример правильной 03.06.1980)', 304);
		
		$this->preSaveCheck = true;
		
		return true;
	}#}}}

    /**
     * @return bool
     * @throws KaApiUserException
     */
    public function save()#{{{
	{
		if (!$this->preSaveCheck) throw new KaApiUserException(sprintf('Перед запуском метода [%s] необходимо выполнить проверку данных [preSave]',__METHOD__));
		
		$mysqli = KaDB::getInstance();
		
		$bcrypt = new Bcrypt(11);
		
		$salt     = KaDB::generateHash(10,20);
		$authHash = KaDB::generateUniqueHashByField('ka_user','_auth_hash');
		
		$pwdHash = $bcrypt->hash($this->email.$this->password.$salt);
		
		if (!isset($this->registerDate))
		{
			$this->registerDate = date('Y-m-d H:i:s');
		}
		
		$insertOk = $this->mysqli->queryFile('/user.sql/new_user'
			,$this->registerDate
			,$mysqli->real_escape_string($this->email)
			,$this->dobClean
			,$pwdHash
			,$salt
			,$authHash
		);
		
		if (!$insertOk) throw new KaApiUserException(nl2br("Ошибка при добавлении нового пользователя\n".$mysqli->error));
		else            return true;
	}#}}}
}
