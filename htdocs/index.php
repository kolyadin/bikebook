<?php
$_globalTimeStart = microtime(1);

session_name('made_by_kolyadin_ru');
session_start();

require_once('../ka/autoload.php');

$app = Ka::Application();

//Устанавливаем настройки
$app->config()->setEnv('production');
$app->config()->setTimeZone('+4');#По умолчанию ставим Московскую временную зону
$app->config()->setDebugMode(true);
$app->config()->setupEnvironment();

#$app->cache('mongo')
#$app->mongo();

//Загружаем конфигурационные файлы
$app->config()->loadConfigFile(sprintf('%s/app/config/globals.%s.conf.php',dirname(__FILE__),$app->config()->getEnv()),'globals');

//Правила маршрутизации
$router = $app->router();
$router->setSource($_SERVER['REQUEST_URI']);

#$app->user()->checkAuthorization();

//Главная страница проекта
$router->setRuleCallback('GET /', function() use ($app) {
	$app->router()->call('/front/indexPage')->run();
});

//Страница байкера (байкерши)
$router->setRuleCallback('GET /(man|woman)/(.+)', function($a,$b) use ($app) {
	//$router->call('/news/view')->setArgs($args)->run();

	$app->config();
});

//Страница авторизации
$router->setRuleCallback('GET /verification', function() use ($app) {
	$app->router()->call('/auth/authPage')->run();
});

//POST запрос на проверку авторизационных данных
$router->setRuleCallback('POST /verification/check', function() use ($app) {
	$app->router()->call('/auth/check')->run();
});

//Страница авторизации
$router->setRuleCallback('GET /verification/exit/', function() use ($app) {
	$app->router()->call('/auth/logOut')->run();
});

<<<<<<< HEAD
//Напоминание пароля
$router->setRuleCallback('GET /verification/forgot-password', function() use ($app) {
	$app->router()->call('/auth/forgotPwd')->run();
});

//Напоминание пароля ajax
$router->setRuleCallback('GET /verification/forgot-password/ajax', function() use ($app) {
	$app->router()->call('/auth/forgotPwdAjax')->run();
});

=======
>>>>>>> origin/master
//Страница регистрации
$router->setRuleCallback('GET /new-biker', function() use ($app) {
	$app->router()->call('/register/registerPage')->run();
});

//POST запрос на проверку регистрационных данных
$router->setRuleCallback('POST /new-biker/check', function() use ($app) {
	$app->router()->call('/register/check')->run();
});

//Активация юзверя по мылу
$router->setRuleCallback('GET /new-biker/email-confirm/(.+)', function($hash) use ($app) {
	$app->router()->call('/register/confirm')->setArgs(array($hash))->run();
});

$usageMemory = function($bytes)
{
	$bytesDiv = $bytes/1024;

	if ($bytesDiv>1 && $bytesDiv <= 1024) return sprintf('%.2f Kb',$bytesDiv);//Килобайты
	else if ($bytesDiv/1024>1)            return sprintf('%.3f Mb',$bytesDiv/1024);//Мегабайты

	return sprintf('%.2f b',$bytes);//Байты
};

/*
printf("\n\n<br/><br/>%.6f<br/>%s"
	,microtime(1)-$_globalTimeStart
	,$usageMemory(memory_get_usage())
);
*/

<<<<<<< HEAD
#print $app->genTime();
#$app->stopwatch()->dump();
=======
print $app->genTime();
$app->stopwatch()->dump();
>>>>>>> origin/master

#print '<pre>'.print_r($app->mysqli()->q,true).'</pre>';