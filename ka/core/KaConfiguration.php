<?php
class KaConfiguration implements CacheOperator
{
	private $configData = array();
	private $app;
	private $env = null;

	private $debugMode = true;

	private $useCache, $cleanCache = false;
	private $cacheLifetime = 0;

	private static $instance = null;

	/**
	 * Поддержка оператора кэширования
	 * @return KaConfiguration
	 */
	public function useCache($lifetime = '1m')
	{
		$this->useCache = true;
		$this->cacheLifetime = $lifetime;

		return $this;
	}

	public function cleanCache()
	{
		$this->cleanCache = true;

		return $this;
	}

	private function flushCacheInfo()
	{
		$this->useCache = false;
		$this->cacheLifetime = 0;
		$this->cleanCache = false;
	}

	public static function getInstance(Ka $app)
	{
		if (self::$instance == null) {
			self::$instance = new self($app);
		}

		return self::$instance;
	}

	public function __construct(Ka $app)
	{
		$this->app = $app;
	}

	public function __get($name)
	{
		if (isset($this->configData[$name])) {
			return $this->configData[$name];
		}
	}

	public function loadConfigFile($file, $sectionName, $shift = '')
	{
		$app =& $this->app;

		$cacheKey = sprintf('__config_file_' . $sectionName);

		$getConfigFile = function ($tryFile) use (&$app) {
			$fileType = pathinfo($tryFile, PATHINFO_EXTENSION);

			if (!file_exists($tryFile)) {
				switch ($fileType) {
					case 'php':
						throw new KaException(sprintf('Указанного PHP файла [%s] с настройками не существует', $tryFile), 401);
						break;
					case 'json':
						throw new KaException(sprintf('Указанного JSON файла [%s] с настройками не существует', $tryFile), 401);
						break;
				}
			}

			if ($fileType == 'json') {
				$fileData = file_get_contents($tryFile);
				return json_decode($fileData, true);
			} else if ($fileType == 'php') {
				return include_once($tryFile);
			}

			return false;
		};

		if ($this->cleanCache) {
			$app->cache()->delete($cacheKey);
			$this->useCache = false;
		}

		if ($this->useCache) {
			$dataReady = $app->cache()
				->set($cacheKey, $this->cacheLifetime)
				->call(function () use ($file, $getConfigFile) {
					return $getConfigFile($file);
			});
		} else {
			$dataReady = $getConfigFile($file);
		}

		//Пути для автозагрузки
		if (isset($dataReady['_autoload']))
		{
			$searchDirs = $dataReady['_autoload'];

			spl_autoload_register(function($className) use($searchDirs) {
				foreach ($searchDirs as $dir)
				{
					$checkFile = $dir.'/'.$className.'.php';

					if (file_exists($checkFile))
					{
						require_once($checkFile);
						break;
					}
				}
			});

			unset($dataReady['_autoload']);
		}

		if ($shift) $dataReady = $dataReady[$shift];
		$this->configData[$sectionName] = $dataReady;

		$this->flushCacheInfo();
	}

	public function setEnv($env)
	{
		$this->env = $env;
	}

	public function getEnv()
	{
		return $this->env;
	}

	public function setTimeZone($timezone)
	{
		$timezone = trim($timezone);

		switch (substr($timezone, 0, 1)) {
			case '+':
				$timezone = str_replace('+', '-', $timezone);
				break;

			case '-':
				$timezone = str_replace('-', '+', $timezone);
				break;

			default:
				$timezone = '-' . $timezone;
				break;
		}

		date_default_timezone_set('Etc/GMT' . $timezone);
	}

	public function setDebugMode($bool)
	{
		$this->debugMode = $bool;
	}

	public function isDebugMode()
	{
		return $this->debugMode;
	}

	public function setupEnvironment()
	{
		if ($this->debugMode)
		{
			ini_set('error_reporting', E_ALL | E_STRICT);
			ini_set('display_errors', 'On');
			ini_set('display_startup_errors', 'On');
		}
		else
		{
			ini_set('error_reporting', E_ERROR);
			ini_set('display_errors', 'Off');
			ini_set('display_startup_errors', 'Off');
		}

		ini_set('html_errors', 'On');
		ini_set('docref_root', '');
		ini_set('docref_ext', '');

		ini_set('log_errors', 'On');
		ini_set('log_errors_max_len', 0);
		ini_set('ignore_repeated_errors', 'Off');
		ini_set('ignore_repeated_source', 'Off');
		ini_set('report_memleaks', 'Off');
		ini_set('track_errors', 'On');
		ini_set('xmlrpc_errors', 'Off');
		ini_set('xmlrpc_error_number', 'Off');
		ini_set('error_prepend_string', '');
		ini_set('error_append_string', '');
		#ini_set('error_log', $error_log);
	}
}