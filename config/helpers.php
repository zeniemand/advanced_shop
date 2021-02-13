<?php

//Отладка без предкащения выполнения скрипта:
function debug($var){
    echo "<pre>";
    print_r ($var);
    echo "</pre>";
}

//Отладка с прекращением выполнения скрипта:
function dd($var){
    echo "<pre>";
    print_r ($var);
    echo "</pre>";
    die;
}

//Перенаправление по заданному урл:
function redirect($url){
    header("Location: {$url}");
}

//Вернуть откуда пришел:
function back(){
    $referrer = $_SERVER['HTTP_REFERER'];
    header("Location: {$referrer}");
}