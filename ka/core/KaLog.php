<?php
class KaLog
{
	private $app;

	private $file = '';

	public function __construct(Ka $app,$file = '')
	{
		$this->app = $app;

		if ($file) $this->file = $file;
	}

	public function write($content)
	{
		$f = fopen($this->app->config()->globals['logPath'].'/'.$this->file.'.log','a+');
		flock($f,LOCK_EX);
		fwrite($f,"[".date('d.m.Y H:i:s')." | {$_SERVER['REMOTE_ADDR']}] $content\n\n");
		flock($f,LOCK_UN);
		fclose($f);
	}
}
