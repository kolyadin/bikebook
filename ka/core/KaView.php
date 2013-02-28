<?php
class KaView
{
	public $userData = array();

	public $title = '';

	private static $instanceBasic, $instanceTwig = null;
	private static $app;

	/**
	 * @return KaView
	 */
	public static function instanceBasic()
	{
		if (self::$instanceBasic == null)
		{
			self::$instanceBasic = new self;
		}

		return self::$instanceBasic;
	}

	public static function instanceTwig(Ka $app)
	{
		self::$app = $app;

		if (self::$instanceTwig == null)
		{
			self::$instanceTwig = self::connectTwig();
		}

		return self::$instanceTwig;
	}

	private static function connectTwig()
	{
		$config = self::$app->config();

		require_once $config->globals['libPath'].'/3rdparty/Twig/Autoloader.php';

		Twig_Autoloader::register();

		$loader = new Twig_Loader_Filesystem($config->globals['viewPath']);

		$twig = new Twig_Environment($loader, array(
			'cache' => $config->globals['PROJECT_ROOT'].'/data/twig-cache',
			'auto_reload' => $config->isDebugMode() ? true : false,
			'autoescape'  => false
		));

		$twig->addGlobal('user',array(
			 'who'  => self::$app->user()->who()
			,'data' => self::$app->user()->data
		));

		$function = new Twig_SimpleFunction('js', function () {
			$args = func_get_args();

			$files = $args[0];

			$checksum = 0;

			foreach ($files as $file)
			{
				$checksum .= $file[0];

				//version
				if (isset($file[1])) $checksum .= $file[1];

				printf('<script type="text/javascript" src="%s"></script>'."\n"
					,$file[0].(isset($file[1]) ? '?'.$file[1] : '')
				);
			}

			$checksum = sprintf('%u.js',crc32($checksum));
		});

		$twig->addFunction($function);

		return $twig;
	}

	public function __construct()
	{

	}

	/**
	 * @param $template
	 * @param array $vars
	 */
	public function loadAndRender($template,array $vars = array())
	{
		print $this->load($template,$vars);
	}

	/**
	 * @param $template
	 * @param array $vars
	 * @return string
	 */
	public function load($template,array $vars = array())
	{
		ob_start();
		
		if (!defined('isAuthorized')) define('isAuthorized', KaAuth::isAuthorized());
		$this->userData = KaAuth::$userData;
		
		$vars['_view'] = $this;
		
		if (count($vars)) extract($vars);
		
		require_once(DOCUMENT_ROOT.'/app/view/'.$template);
		
		return ob_get_clean();
	}

	/**
	 * Ставим <title страницы
	 * @param $title
	 * @return KaView
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	public function staticPath($filePath)
	{
		print $this->getStaticPath($filePath);
	}
	
	public function getStaticPath($filePath)
	{
		$httpHost = 'http://test1.loc';
		
		return $httpHost.$filePath;
	}

	public function js()
	{
		return new KaViewJs;
	}
}

class KaViewJs
{
	private $compress = false;
	private $useStatic = false;
	private $version = '';

	public function __construct()
	{
		return $this;
	}

	/**
	 * Сжимает JS файлы в один файл
	 * @return KaViewJs
	 */
	public function compress()
	{
		$this->compress = true;
		return $this;
	}

	/**
	 * @return KaViewJs
	 */
	public function useStatic()
	{
		$this->useStatic = true;
		return $this;
	}

	/**
	 *
	 * @return KaViewJs
	 */
	public function version($version)
	{
		$this->version = $version;
		return $this;
	}

	/**
	 *
	 */
	private function fileCheckUrl($file)
	{
		$checkUrl = parse_url($file);

		return array(
			 'path'    => $file
			,'content' => isset($checkUrl['host'])
				? file_get_contents($file)
				: file_get_contents(DOCUMENT_ROOT.$file)
		);
	}

	public function deploy($path)
	{
		$files = array();
		$checksum = '';

		if (is_array($path))
		{
			foreach ($path as $file)
			{
				$checksum .= $file[0].'?'.$this->version;
			}
		}
		else
		{
			$checksum = $path.'?'.$this->version;
		}

		$checksum = sprintf('%u.js',crc32($checksum));
		$checkFile = DOCUMENT_ROOT.'/js/gen/'.$checksum;

		if ($this->compress)
		{
			if (!file_exists($checkFile))
			{
				$onlyOneName = '/js/gen/'.$checksum;

				if (is_array($path))
				{
					foreach ($path as $file)
					{
						$files[] = $this->fileCheckUrl($file[0]);
					}

					foreach ($files as $file)
					{
						file_put_contents(DOCUMENT_ROOT.$onlyOneName,$file['content'],FILE_APPEND | LOCK_EX);
					}
				}
				else
				{
					$file = $this->fileCheckUrl($path);
					file_put_contents(DOCUMENT_ROOT.$onlyOneName,$file['content'],LOCK_EX);
				}
			}

			printf('<script type="text/javascript" src="/js/gen/%s"></script>'."\n", $checksum);
		}
		else
		{
			if (is_array($path))
			{
				foreach ($path as $file)
				{
					printf('<script type="text/javascript" src="%s?%s"></script>'."\n"
						,$file[0]
						,$this->version
					);
				}
			}
			else
			{
				printf('<script type="text/javascript" src="%s?%s"></script>'."\n"
					,$path
					,$this->version
				);
			}
		}
	}
}