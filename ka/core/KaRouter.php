<?php
class KaRouter
{
	private $app,$checkString,$checkStringClean,$envMode;
	private $alreadyRan = false;
	private static $instance = null;

	public static function getInstance(Ka $app,$envMode)
	{
		if (self::$instance == null)
		{
			self::$instance = new self($app,$envMode);
		}

		return self::$instance;
	}

	public function __construct(Ka $app,$envMode)
	{
		$this->app = $app;
		$this->envMode = $envMode;

		return $this;
	}

	public function __destruct()
	{
		if (!$this->alreadyRan)
		{
			#KaModuleHeaders::header404();
		}
	}

	public function setOptions($mask)
	{

	}

	public function option($option)
	{
		$a = getopt('a:');
		return $a;
		/*
		$options = $_SERVER['argv'];

		array_shift($options);

		return $options;
		*/
	}

	public function perms()
	{

	}

	public function setSource($source)
	{
		$this->checkString = $this->checkStringClean = $source;

		if (strpos($source,'?') !== false)
		{
			$this->checkStringClean = strstr($source,'?',true);
		}
	}

	/**
	 * @param $urlMask
	 * @return none
	 */
	public function setPermissions($urlMask)
	{
		preg_match('@\A(.+)\s+(\/.*)\z@',$urlMask,$matches);

		if (count($matches) != 3) return false;

		list(,$requestMethod,$cleanMask) = $matches;

		$requestMethod = trim($requestMethod);

		$methods = preg_split('@\s@',$requestMethod);

		if (!in_array($_SERVER['REQUEST_METHOD'],$methods)) return false;

		print $cleanMask;

		if ($this->checkMask($cleanMask))
		{
			print 'NEED PERMS!';
		}
		else
		{
			print 'NO NEED PERMS';
		}
	}

	public function setRuleCallback($mask,$callback)
	{
		if ($this->alreadyRan) return;

		preg_match('@\A(.+)\s+(\/.*)\z@',$mask,$matches);

		if (count($matches) != 3) return false;

		list(,$requestMethod,$cleanMask) = $matches;

		$requestMethod = trim($requestMethod);

		$methods = preg_split('@\s@',$requestMethod);

		if (!in_array($_SERVER['REQUEST_METHOD'],$methods)) return false;

		if ($callMethodArgs = $this->checkMask($cleanMask))
		{
			$this->alreadyRan = true;

			if (is_array($callMethodArgs))
			{
				call_user_func_array($callback,$callMethodArgs);
			}
			else
			{
				$callback();
			}
		}
	}

	private function checkMask($mask)
	{
		if (strpos($mask,'(') !== false)
		{
			if (preg_match("@\A$mask\z@",$this->checkStringClean,$callMethodArgs))
			{
				array_shift($callMethodArgs);

				return $callMethodArgs;
			}
		}
		else if ($mask == $this->checkStringClean)
		{
			return true;
		}

		return false;
	}

	/**
	 * @param $mask
	 * @param $newLocation
	 * @param $callback
	 * @return KaRouter
	 */
	public function setRedirect($mask,$newLocation,$callback = '')
	{
		if (preg_match("@\A$mask\z@",$this->checkStringClean))
		{
			if (is_callable($callback))
			{
				$callback();
			}

			$location = preg_replace("@\A$mask\z@",$newLocation,$this->checkStringClean);

			header("Location: $location",true,301);
			die;
		}

		return $this;
	}

	public function call($command)
	{
		return new KaRouterRule($command,$this->app);
	}

	public function set404()
	{

	}

}

class KaRouterPerms
{

}

class KaRouterRule
{
	private $callback;
	private $args = null;
	private $app;

	/**
	 * @param $callRule
	 * @param KaRouter $routerObject
	 */
	public function __construct($callRule, Ka $app)
	{
		$this->app = $app;

		$p = preg_split('@\/@',$callRule,-1,PREG_SPLIT_NO_EMPTY);

		$method = array_pop($p);
		$controller = $filename = array_pop($p);

		$filepath = $app->config()->globals['controllerPath'].'/'.(count($p) ? implode('/',$p).'/' : '').$filename.'.php';

		require_once($filepath);

		//Вызываем статический метод
		if (strpos($method,':') !== false)
		{
			$this->callback = "$controller::$method";
		}
		else
		{
			$this->callback = array($controller,$method);
		}

		#print '<pre>'.print_r($this->callback,true).'</pre>';

		return $this;
	}

	/**
	 * @param array $args
	 * @return KaRouterRule
	 */
	public function setArgs($args = array())
	{
		if (count($args)) $this->args = $args;
		
		return $this;
	}

	public function run()
	{
		if (is_array($this->callback))
		{
			$callback = array(new $this->callback[0](),$this->callback[1]);
		}
		else
		{
			$callback = $this->callback;
		}

		call_user_func_array($callback,$this->args ? $this->args : array());
	}
}
