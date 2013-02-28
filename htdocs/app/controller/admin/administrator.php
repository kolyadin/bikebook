<?php
class KaControllerAdministrator extends KaController
{
	public function adminList()
	{
		$data['list'] = $this->model->load('/admin/admin.php')->adminList();



		$this->view->loadAndRender('/admin/administrator/list.php',$data);
	}

	public function edit()
	{
		$tpl = array();

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if (isset($_POST['mobile_number']) && !empty($_POST['mobile_number']) && !isset($_POST['verify_code']))
			{
				$tpl['verifyMobile'] = true;

				$verifyCode = rand(111111,999999);

				require_once(KaConfig::$DOCUMENT_ROOT.'/lib/3rdparty/LittleSMS.php');

				$user = 'donflash@gmail.com';            // логин указанный при регистрации или логин api-аккаунта http://littlesms.ru/my/settings/api
				$key  = '01EX25';   // API-key, узнать можно тут: http://littlesms.ru/my/settings/api
				$ssl  = true;                 // использовать защищенное SSL-соединение

				$api = new LittleSMS($user, $key, $ssl);

				$api->messageSend($_POST['mobile_number'], sprintf('Parol dlya vhoda %s',$verifyCode));

				$_SESSION['verifyCode'] = $verifyCode;
			}
			else if (isset($_SESSION['verifyCode']) && $_SESSION['verifyCode'] == $_POST['verify_code'])
			{
				$bcrypt = new Bcrypt(KaConfig::bcryptHashLevel);

				$mysqli = KaDB::getInstance();

				$pwd  = $_POST['pwd'];
				$salt = KaDB::generateHash(10,20);
				#$authHash = KaDB::generateUniqueHashByField('ka_admin','_auth_hash');

				$pwdHash = $bcrypt->hash($pwd.$salt);

				$mysqli->query(sprintf('INSERT INTO ka_admin SET username = "%s", _pwd_hash = "%s", _salt = "%s", _mobile = "%s"'
					,$mysqli->real_escape_string($_POST['username'])
					,$pwdHash
					,$salt
					,$mysqli->real_escape_string($_POST['mobile_number'])
				));

				unset($_SESSION['verifyCode']);
			}
		}

		$this->view
		->setTitle('Новая администрация')
		->loadAndRender('/admin/administrator/edit.php',$tpl);

	}
}