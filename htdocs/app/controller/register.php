<?php
class register extends KaController
{
	private $auth;

	public function __construct()
	{
	}

	public function registerPage()
	{
		$this->view->display('register.twig');
	}

	public function confirm($hash)
	{
		$mysqli = $this->app->mysqli();

		$result = $mysqli->squery('SELECT id FROM ka_user WHERE SHA1(CONCAT(email,_salt)) = "%s" AND _activated = 0 LIMIT 1'
			,$mysqli->escape($hash)
		);

		if ($result->num_rows == 1)
		{
			$id = $result->fetch_row();

			$mysqli->squery('UPDATE ka_user SET _activated = 1 WHERE id = %u',$id);

			header('Location:/verification');
			die;
		}
	}

	public function check()
	{
		try
		{
			if (
				!isset($_POST['reg-email']) ||
				!isset($_POST['reg-pwd']) ||
				!isset($_POST['reg-sex'])
			)
			{
				throw new KaException('Недостаточно данных для регистрации',401);
			}

			$data = array(
				 'email' => $_POST['reg-email']
				,'pwd'   => $_POST['reg-pwd']
				,'sex'   => $_POST['reg-sex']
			);

			$app =& $this->app;

			$userData = $app->register()->proceed($data);

			//Загружаем конфигурационные файлы
			$app->config()->loadConfigFile(sprintf('%s/app/config/text.ru.conf.php',$app->config()->globals['DOCUMENT_ROOT']),'text');

			$mail = $app->mailer();

			$mail->CharSet = 'UTF-8';
			$mail->AddAddress($data['email']);
			$mail->SetFrom('robot@bikebook.ru', 'Почтовый робот');
			$mail->Subject = 'Подтвердите регистрацию на bikebook.loc';
			#$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			$mail->MsgHTML(sprintf($app->config()->text['emailMessageAfterRegister']
				,sha1($userData['email'].$userData['_salt'])
			));
			#$mail->AddAttachment('images/phpmailer.gif');      // attachment
			#$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
			$mail->Send();

			header('Location:/new-biker');
		}
		catch (KaException $e)
		{
			switch($e->getCode())
			{
				case 301:
					print 'Ошибка неправильной почты';
					break;
				case 302:
					print 'Ошибка неправильного пароля';
					break;
			}


			$this->view->display('register.twig');
		}
	}
}