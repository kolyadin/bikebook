<?php
class KaStopWatch
{
	private $app;

	private static $instance = null;
	private $timerName;
	private $timers;
	private $start;

	public static function getInstance(Ka $app,$timerName)
	{
		if (self::$instance == null)
		{
			self::$instance = new self($app,$timerName);
		}

		self::$instance->timerName = $timerName;

		return self::$instance;
	}

	public function __construct(Ka $app,$timerName)
	{
		$this->app = $app;
	}

	public function start()
	{
		$this->start = microtime(1);
	}

	public function stop()
	{
		$this->timers[] = array($this->timerName,sprintf('%.6f',microtime(1)-$this->start));
	}

	public function dump()
	{
		print '<pre>'.print_r($this->timers,true).'</pre>';
	}
}