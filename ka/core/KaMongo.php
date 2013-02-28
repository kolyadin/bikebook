<?php
class KaMongo
{
	private $app;
	private static $instance = null;

	public static function getInstance(Ka $app)
	{
		if (self::$instance == null)
		{
			self::$instance = self::getConnection($app);
		}

		return self::$instance;
	}

	public static function getConnection(Ka $app)
	{
		$m = new MongoClient();

		$mongo = $m->selectDB($app->config()->globals['mongo']['db']);

		return $mongo;
	}
}
