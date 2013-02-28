<?php
class KaResizer
{
	private $app;
	private static $instance = null;

	private $noStatic = false;

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
		$this->app->config()->loadConfigFile($this->app->config()->globals['DOCUMENT_ROOT'].'/app/config/resizer.conf.php','resizer');
	}

	private function generateFilename($file,$salt)
	{
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		$hash = sha1($file.$salt);

		$localPath = $this->app->config()->globals['picPath'].'/'.substr($hash,0,3).'/'.substr($hash,3,2).'/'.substr($hash,5,2);

		$crc32 = crc32($hash);

		$tryFile = sprintf('%s/%u.%s'
			,$localPath
			,$crc32
			,$fileType
		);

		return $tryFile;
	}

	/**
	 * @param $file
	 * @return string
	 */
	private function getLink($file)
	{
		if ($this->noStatic)
		{
			$this->noStatic = false;
			return $file;
		}

		//Данная опция не грузит статику с production
		if ($this->app->config()->resizer['useOnlyStaticServers'])
		{
			$servers = array_keys($this->app->config()->globals['staticServers']);

			return sprintf('http://%s%s',$servers[array_rand($servers,1)],$file);
		}

		return $file;
	}

	/**
	 * @return KaResizer
	 *
	 * Вывод изображения с production
	 * Запрещаем использовать статичный сервер
	 */
	public function noStatic()
	{
		$this->noStatic = true;

		return $this;
	}

	/**
	 * @param $sourceFile
	 * @param $options
	 * @return string
	 */
	public function resize($sourceFile,$options)
	{
		$config = $this->app->config();
		$cache  = $this->app->cache();
		$mysqli = $this->app->mysqli();

		$file = array();

		$file['sourceRel'] = $sourceFile;
		$file['sourceAbs'] = $config->globals['DOCUMENT_ROOT'].$sourceFile;

		$file['newRel'] = str_replace($config->globals['DOCUMENT_ROOT'],'',$this->generateFilename($file['sourceAbs'],$options));
		$file['newAbs'] = $config->globals['DOCUMENT_ROOT'].$file['newRel'];

		//Контрольный checksum для всех параметров (нужно для быстрого поиска)
		$commandHash = md5($file['sourceRel'].$file['newRel'].$options);

		//Проверяем на наличие нужного изображения в БД (используется кэш)

		$this->app->stopwatch('mysqli/gen-pic-find')->start();

		$fileExists = $cache->set('mysqli_'.$commandHash,'10s')->call(function() use($mysqli,$commandHash) {
			$result = $mysqli->squery('SELECT id_hash FROM ka_pic_history WHERE id_hash = "%s"',$commandHash);
			return ($result->num_rows == 1 ? true : false);
		});

		$this->app->stopwatch('mysqli/gen-pic-find')->stop();

		//Если в БД уже есть путь до нужного изображения, сразу выводим его
		//(подразумевается, что файл существует)
		if ($fileExists)
		{
			//Обновляем информацию о последнем доступе к изображению
			//Эта хрень поможет нам в последствии сносить невостребованные изображения

			$this->app->stopwatch('mysqli/update-pic-time')->start();

			$this->app->mysqli()->squery('UPDATE LOW_PRIORITY ka_pic_history SET timeAccess = "%s" WHERE id_hash = "%s"'
				,date('Y-m-d H:i:s')
				,$commandHash
			);

			$this->app->stopwatch('mysqli/update-pic-time')->stop();

			return $this->getLink($file['newRel']);
		}

		//Создаем папки под хранение и выставляем нужные права доступа

		$path = pathinfo($file['newAbs']);

		if (!is_dir($path['dirname']))
		{
			mkdir($path['dirname'],0777,true);
			chmod($path['dirname'],0777);
		}

		$opts = array();

		$opts['resizeCmd'] = '';
		$opts['q'] = 90;

		$optionsJson = json_decode($options,true);

		//Ширина
		if (isset($optionsJson['w']))
		{
			$opts['resizeCmd'] .= $optionsJson['w'];
		}

		//Высота
		if (isset($optionsJson['h']))
		{
			$opts['resizeCmd'] .= 'x'.$optionsJson['h'];
		}

		//Пропорции
		if (isset($optionsJson['p']) && $opt['p'] == 1)
		{
			$opts['resizeCmd'] .= '!';
		}

		//Прямой вызов команды
		if (isset($optionsJson['exec']))
		{
			$opts['resizeCmd'] = $optionsJson['exec'];
		}

		//Качество
		if (isset($optionsJson['q']))
		{
			$opts['q'] = $optionsJson['q'];
		}

		//Подготавливаем команду для выполнения необходимой операции
		$command = sprintf('%s %s -resize \'%s\' -strip -quality %u -quiet -synchronize %s'
			,$config->globals['bin']['convert']
			,$file['sourceAbs']
			,$opts['resizeCmd']
			,$opts['q']
			,$file['newAbs']
		);

		//Необходимая команда будет выполняться через flock, это делается для гарантированного запуска в один поток

		$lockFile = sha1($command).'.lock';

		exec(sprintf('%s %s/%s %s -c "%s" 2>&1'
			,$config->globals['bin']['lock']
			,$config->globals['tmp']
			,$lockFile
			,$config->globals['bin']['bash']
			,$command
		),$output);

		//Во время генерации произошла ошибка, делаем запись в лог
		if (count($output))
		{
			$this->app->log('error')->write("Ошибка при генерации изображения\n\n".implode("\n",$output));

			//@todo В случае ошибки выводить какую-нить заглушку или типа того

			return;
		}

		//Записываем данные в БД, в следующий раз при обращении к этому же изображению, мы отдадим
		//готовый путь до изображения без повторной генерации
		// +
		//Если будет запрошен прямой адрес до несуществующей картинки, используя сохраненные данные в БД (options)
		//приложение восстановит нужное изображение
		$this->app->mysqli()->squery('INSERT INTO ka_pic_history SET id_hash = "%s", source_file = "%s", timeCreate = "%s", timeAccess = "%s", file = "%s", options = "%s"'
			,$commandHash
			,$this->app->mysqli()->escape($file['sourceRel'])
			,date('Y-m-d H:i:s')
			,date('Y-m-d H:i:s')
			,$this->app->mysqli()->escape($file['newRel'])
			,$this->app->mysqli()->escape($options)
		);

		return $this->getLink($file['newRel']);
	}

	public function identify($command)
	{

	}
}