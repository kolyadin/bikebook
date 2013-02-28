<?php
class KaCore
{
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

	/**
	 * @param $moduleName
	 */
	public function module($moduleName)
	{
		switch ($moduleName)
		{
			case 'router':
				return new KaRouter;
			break;
		}
	}
}