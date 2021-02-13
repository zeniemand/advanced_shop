<?php

class CabinetController
{
    public function actionIndex()
    {

        $userId = User::checkLogged();

        $user = User::getUserById($userId);

        debug($_SESSION);

        require_once ROOT . '/views/cabinet/index.php';

        return true;
    }

    public function actionEdit()
    {


        //Получаем идентификационный номер пользователя:
        $userId = User::checkLogged();

        //Получаем данные пользователя из БД:
        $user = User::getUserById($userId);

        //dd($user);

        $name = $user['name'];
        $password = $user['password'];

        $result = false;

        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $password = $_POST['password'];

            $errors = false;

            //> Валидация полей:
            if(!User::checkName($name)){
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }

            if(!User::checkPassword($password)){
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            //<

            if($errors == false){
                $result = User::edit($userId, $name, $password);
            }


        }

        require_once ROOT . '/views/cabinet/edit.php';

        return true;
    }

}