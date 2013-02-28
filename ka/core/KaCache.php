<?php
class KaCache
{
	private $memObject,$name,$lifetime;

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
		$this->memObject = new Memcached();
		$this->memObject->addServer('127.0.0.1', 11211);

		$this->app = $app;
	}



	public function set($name,$lifetime,$tag='')
	{
		$this->name = $name;
		
		$ttl = strtr($lifetime,array(
			 's' => '*1'
			,'month' => '*3600*24*30'
			,'m' => '*60'
			,'h' => '*3600'
			,'d' => '*3600*24'
			,'y' => '*3600*24*365'
		));

		$addTime = eval("return $ttl;");

		if ($addTime >= 60*60*24*30) $this->lifetime = time() + $addTime;
		else                         $this->lifetime = $addTime;

		return $this;
	}
	
	private function parseTime()
	{
		
	}
	
	public function get($name)
	{
		return $this->memObject->get($name);
	}
	
	public function call($callback)
	{
		if (!is_callable($callback)) throw new KaException('Неверный аргумент',401);
		if (empty($this->name) || empty($this->lifetime)) throw new KaException('Не установлено название кэша и/или время жизни',402);

		if ($return = $this->get($this->name))
		{
			return $return;
		}
		else
		{
			$callbackData = $callback();
			$this->memObject->set($this->name,$callbackData,$this->lifetime);

			return $callbackData;
		}
	}

	public function delete($name)
	{
		$this->memObject->delete($name);
	}
	
	public function flush()
	{
		$this->memObject->flush();
	}
	
	public function flushTag($tagName)
	{
		
	}
	
	/*
	$data = $this->cache->set('test1','24s',['a','b'])->call(function(){
		
	});
	
	$this->cache->get('test1');
	
	$this->cache->flush('test1');
	$this->cache->flushTag('alfa');
	$this->cache->flushTag(array('alfa','beta'));
	*/
}
