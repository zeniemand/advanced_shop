<?php


class DB
{
    public static function getConnection()
    {
        //Подключение файла с параметрами:
        $paramsPath = ROOT . '/config/db_params.php';

        //Сохранение данных из него в переменную:
        $params = include($paramsPath);

        //dd($params['host']);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'"]);

        return $db;
    }


}
