<?php
//Фронтконтроллер






//Общие настройки:

//Включение и отображение ошибок:
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Открываем сессию:
session_start();

//phpinfo();


// Подключение файлов системы:

//Определим константу корневого пути:
define('ROOT', dirname(__FILE__));

//Подключаем автозагрузчик классов:
require_once ROOT . '/components/Autoload.php';

////Подключаем роутер:
//require_once ROOT . '/components/Router.php';
//
////Подключаем сединение с БД:
//require_once ROOT . '/components/DB.php';

//Подключаем хелперы:
require_once ROOT . '/config/helpers.php';

//phpinfo();

/*debug(['ROOT: ' => ROOT]);

dd($_SERVER['DOCUMENT_ROOT']);*/


// Установка соединения

// Вызов роутера:
$router = new Router();
$router->run();