<?php

abstract class AdminBase
{
    /**
     * Проверка прав доступа пользователя:
     *
     * @return bool
     */
    public function checkAdmin()
    {
        //Получаем айди текущего пользователя:
        $userId = User::checkLogged();

        //Получаем данные пользователя по айди:
        $user = User::getUserById($userId);
        //dd($user);

        //Проверяем роль полученного пользователя:
        if($user['role'] == 'admin'){
            return true;
        }

        die('Access denied');
    }

}