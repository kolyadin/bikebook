<?php
class KaDB extends mysqli implements CacheOperator
{
	private static $mysqli = null;
	private static $app;
	
	public $q = array();
	
	public static function getInstance(Ka $app)
	{
		if (self::$mysqli == null)
		{
			self::$mysqli = self::getConnection($app);
		}
		
		return self::$mysqli;
	}

	public static function getConnection(Ka $app)
	{
		self::$app = $app;

		$config = $app->config()->globals['mysqli'];

		if (
			!isset($config['username']) ||
			!isset($config['password']) ||
			!isset($config['dbname'])
		) throw new KaException('Не установлены необходимые параметры для подключения к БД');

		$self = new self(
			 $config['hostname']
			,$config['username']
			,$config['password']
			,$config['dbname']
			,$config['port']
			,$config['socket']
		);

		$self->query('SET NAMES utf8');
		
		return $self;
	}

	/**
	 * Поддержка оператора кэширования
	 * @return KaConfiguration
	 */
	public function useCache($lifetime = '1m')
	{

	}

	public function cleanCache()
	{

	}

	public function squery()
	{
		$args = func_get_args();

		$command = $args[0];

		array_shift($args);

		return $this->query(vsprintf($command,$args));
	}
	
	public function query($query)
	{
		$s = microtime(1);
		
		$object = parent::query($query);
		
		$this->q[] = array(
			 'query' => $query
			,'time'  => sprintf('%.6f',microtime(1)-$s)
			#,'trace' => debug_backtrace()
		);
		
		return $object;
	}

	public function escape($value)
	{
		return parent::real_escape_string($value);
	}
	
	public function queryFile()
	{
		$args = func_get_args();
		
		$command = $args[0];
		
		array_shift($args);
		
		#/user.sql/new_user
		
		list(,$file,$section) = explode('/',$command);
		
		$text = file_get_contents(self::$app->config()->globals['sqlPath'].'/'.$file);
		
		$blocks = preg_split('@\[(.+)\]@',$text,-1,PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
		
		$ar = $ab = array();
		
		foreach ($blocks as $key => $line)
		{
			if ($key&1) $ar[] = $line;
			else        $ab[] = $line;
		}
		
		$c = array_combine($ab,$ar);

		return $this->query(vsprintf($c[$section],$args));
	}

	public function fetch_assoc_all()
	{
		return 123;
	}
	
	public static function generateHash($min = 50,$max = 100)
	{
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charsLength = strlen($chars)-1;
		
		$specchars = '!@#$().-_';
		$speccharsLength = strlen($specchars)-1;
		
		$str = '';
		
		for ($i=1;$i<=rand($min,$max);$i++)
		{
			if (rand(1,6) == 6)
			{
				$str .= $specchars{rand(0,$speccharsLength)};
			}
			else
			{
				$str .= $chars{rand(0,$charsLength)};
			}
		}
		
		return $str;
	}
	
	public function generateUniqueHashByField($table,$field,$params = array())
	{
		if (!count($params)) $params = array('minLength'=>120,'maxLength'=>180);
		
		if (isset($params['minLength']) || isset($params['maxLength']))
		{
			$str = $this->generateHash($params['minLength'],$params['maxLength']);
		}
		else
		{
			$str = $this->generateHash();
		}
		
		$result = $this->query(sprintf('SELECT count(*) FROM %s WHERE %s = "%s"'
			,$table
			,$field
			,$str
		));
		
		list($count) = $result->fetch_row();
		
		if ($count >= 1) return $this->generateUniqueHashByField($table,$field,$params);
		else             return $str;
	}
}
