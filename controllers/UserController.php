<?php


class UserController
{
    public function actionRegister()
    {
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            //dd($_POST);
            //dd($name);
            $errors = false;

            if(!User::checkName($name)){
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }

            if(!User::checkEmail($email)){
                $errors[] = 'Не правильный email';
            }

            if(!User::checkPassword($password)){
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            if(User::checkEmailExists($email)){
                $errors[] = 'Такой email уже используется';
            }

            if($errors == false){
                $result = User::register($name, $email, $password);
            }


        }

        require_once ROOT . '/views/user/register.php';
        return true;
    }

    public function actionLogin()
    {

        $email = '';
        $password = '';

        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            //> Валидация полей:
            if(!User::checkEmail($email)){
                $errors[] = 'Не правильный email';
            }

            if(!User::checkPassword($password)){
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            //<

            //Проверяем существует ли пользователь:
            $userId = User::checkUserData($email, $password);

            //dd($userId);


            if($userId == false){
                $errors[] = 'Не правильные данные для входа на сайт';
            } else {
                //Запоминаем пользователя в сессию:
                User::auth($userId);

                //Перенаправляем пользователя в закрытую часть - кабинет:
                redirect('/cabinet/');

            }


        }

        require_once ROOT . '/views/user/login.php';

        return true;
    }

    public function actionLogout()
    {
        session_start();
        unset($_SESSION['user']);
        redirect('/');
    }

}