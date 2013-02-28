<?php
class auth extends KaController
{
    private $auth;

    public function __construct()
    {
    }

    public function authPage()
    {
        $this->view->display('auth.twig');
    }

	public function check()
	{
		try
		{
			$quickExit = (isset($_POST['quickExit']) && $_POST['quickExit'] == 'yes') ? true : false;

			$hash = $this->app->auth()->proceed($_POST['email'],$_POST['pwd']);

			setcookie('ka_user_auth', $hash, $quickExit ? 0 : strtotime('+1 year'), '/', '.'.$_SERVER['HTTP_HOST']);

			header('Location:/verification');

			//KaHeaders::location('/auth/');
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


			$this->view->display('auth.twig');
		}
	}

	public function forgotPwdAjax()
	{
		$result = $this->app->mysqli()->squery('SELECT email FROM ka_user WHERE email = "%s" LIMIT 1'
			,$this->app->mysqli()->escape($_GET['email'])
		);

		if (!$result->num_rows) die(json_encode(array('status' => 'no_email')));

		list($email) = $result->fetch_row();

		die(json_encode(array(
			'email'  => $email,
			'status' => 'success'
		)));
	}

	public function forgotPwd()
	{
		$this->view->display('auth.twig',array('cat'=>'forgotPwd'));
	}

    public function logOut()
    {
        try
        {
			if (!isset($_GET['hash']) || strlen($_GET['hash']) != 40) throw new KaException('Хэш безопасности отсутствует',403);

            $this->app->auth()->logOut($_GET['hash']);

            setcookie('ka_user_auth', -1, time()-3600, '/', '.'.$_SERVER['HTTP_HOST']);

            $letsGoTo = '/';

            if (isset($_GET['back'])) $letsGoTo = base64_decode($_GET['back']);

            header('Location:'.$letsGoTo);
			die;
        }
        catch (KaException $e)
        {
            switch($e->getCode())
            {
                case 401:
                    print $e->getMessage();
                    break;
                case 402:
                    print $e->getMessage();
                    break;
				case 403:
					print $e->getMessage();
					break;
            }
        }
    }


}