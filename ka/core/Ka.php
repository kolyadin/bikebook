<?php
if (version_compare(PHP_VERSION, '5.3.0', '<'))
{
	die('Версия PHP не подходит. Нужна не менее 5.3.0');
}

class Ka
{
	public $heap,$sys = array();
	private static $instance = null;

	private $runMode;

	public $stopwatch = array();

	public function __construct()
	{
		$this->stopwatch['_app'] = microtime(1);
	}

	/**
	 * @return string
	 *
	 * Затраченное время
	 */
	public function genTime()
	{
		return sprintf('%.6f',microtime(1) - $this->stopwatch['_app']);
	}


	public static function Application()
	{
		if (self::$instance == null)
		{
			self::$instance = new self;
			self::$instance->runMode = 'normal';
		}

		return self::$instance;
	}


	/**
	 * @param string $env
	 * @param string $file
	 * @return Ka|null
	 * @throws KaException
	 *
	 * Быстрая инициализация приложения. Как правило, используется для внедрения в отдельные скрипты (standalone scripts)
	 */
	public static function fastBoot($env='production',$file = 'default')
	{
		if (self::$instance == null)
		{
			self::$instance = new self;
			self::$instance->runMode = 'fastBoot';

			//Устанавливаем настройки

			if (strpos($file,'%') !== false)
			{
				$configFile = sprintf($file,$env);
			}
			else
			{
				$configFile = $file;
			}

			//Задаем путь по умолчанию для файла-конфига, если он явно не указан
			if ($file == 'default')
			{
				$configFile =  sprintf('/data/sites/bikebook.loc/htdocs/app/config/globals.%s.conf.php',$env);
			}

			if (!file_exists($configFile)) throw new KaException('Необходимо указать путь до конфигурационного файла!');

			//Загружаем конфигурационные файлы
			self::$instance->config()->loadConfigFile($configFile,'globals');
			self::$instance->config()->setEnv($env);
			self::$instance->config()->setTimeZone('+4');#По умолчанию ставим Московскую временную зону
			self::$instance->config()->setDebugMode($env == 'production' ? false : true);
			self::$instance->config()->setupEnvironment();
		}

		return self::$instance;
	}

	/**
	 * @return KaAuth|null
	 */
	public function auth()
	{
		return KaAuth::getInstance($this);
	}

	public function register()
	{
		return KaRegister::getInstance($this);
	}

	public function resizer()
	{
		return KaResizer::getInstance($this);
	}

	public function mailer()
	{
		require_once $this->config()->globals['libPath'].'/3rdparty/phpmailer/class.phpmailer.php';

		return new PHPMailer(true);
	}

	public function helper()
	{

	}

	/**
	 * @return KaCache|null
	 */
	public function cache()
	{
		return KaCache::getInstance($this);
	}

	public function stopwatch($timerName = '')
	{
		return KaStopWatch::getInstance($this,$timerName);
	}

	/**
	 * @return KaConfiguration|null
	 */
	public function config()
	{
		return KaConfiguration::getInstance($this);
	}

	public function log($file = '')
	{
		return new KaLog($this,$file);
	}

	/**
	 * @return null
	 */
	public function mongo()
	{
		return KaMongo::getInstance($this);
	}

	/**
	 * @return KaDB|null
	 */
	public function mysqli()
	{
		return KaDB::getInstance($this);
	}

	/**
	 * @return KaHeader
	 */
	public function header()
	{
		return new KaHeader($this);
	}

	/**
	 * @param string $envMode
	 * @return KaRouter|null
	 */
	public function router($envMode = 'http')
	{
		return KaRouter::getInstance($this,$envMode);
	}

	/**
	 * @return KaUser|null
	 */
	public function user()
	{
		return KaUser::getInstance($this);
	}

	public function model()
	{

	}

	/**
	 * @return null|Twig_Environment
	 */
	public function view()
	{
		return KaView::instanceTwig($this);
	}

	/**
	 * @return KaCore|null
	 */
	public function core()
	{
		return KaCore::getInstance($this);
	}
}