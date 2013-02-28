<?php
class KaUser
{
	private $app;
	private static $instance = null;

	public $ip;
	public $data;

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

		$this->ip = $_SERVER['REMOTE_ADDR'];
	}

	public function getLink()
	{

	}

	public function getLinkById($userId)
	{
		$mysqli = $this->app->mysqli();

		$result = $mysqli->squery('SELECT sex,nickname FROM ka_user WHERE id = %u LIMIT 1',$userId);

		list($sex,$nickname) = $result->fetch_row();

		return sprintf('/%s/%s',$sex,$nickname);
	}

	public function getLinkByNickname()
	{

	}

	public function checkAuthorization()
	{

	}

	public function getBrowser()
	{
		return $_SERVER['HTTP_USER_AGENT'];
	}

	public function isRobot()
	{
		if ($this->who() == 'robot') return true;

		return false;
	}

	public function isUser()
	{
		if ($this->who() == 'user') return true;

		return false;
	}

	public function who()
	{
		if ($this->app->auth()->isAuthorized())
		{
			return 'user';
		}
		else
		{
			return 'robot';
		}
	}
}