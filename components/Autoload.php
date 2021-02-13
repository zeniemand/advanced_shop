<?php

function myLoader($class_name)
{
    //debug(['запрошен класс: ' => $class_name]);
    //массив директорий с классами:
    $array_path = [
        '/models/',
        '/components/'
    ];

    foreach ($array_path as $path){
        //Собираение пути к файлу:
        $path = ROOT . $path . $class_name . '.php';
        //проверка, что файл есть, и подключение:
        if(is_file($path)){
            //dd($path);
            require_once $path;
        }
    }

}

spl_autoload_register('myLoader');

