<?php

class AdminCategoryController extends AdminBase
{
    public function actionIndex()
    {

        //проверка прав доступа:
        self::checkAdmin();

        if(isset($_SESSION['status'])){
            $status[] = $_SESSION['status'];
            unset($_SESSION['status']);

        }

        $title = "Категории - управление";
        //полученние всех категорий из бд:
        $categoriesList = Category::getCategoriesListAdmin();

        require_once ROOT . '/views/admin_category/index.php';
        return true;
    }

    public function actionCreate()
    {

        self::checkAdmin();


        if(isset($_POST['submit'])){

            $options = array();

            $options['name'] = $_POST['name'];
            $options['sort_order'] = $_POST['sort_order'];
            $options['status'] = $_POST['status'];

            $errors = false;

            if(!isset($options['name']) || empty($options['name'])){
                $errors[] = 'Заполните поле названия категории';
            }

            if(!Category::createCategory($options)){
                $errors[] = 'Не удалось доабвить новую категорию в БД';
            }


        }

        require_once ROOT . "/views/admin_category/create.php";
        return true;
    }

    public function actionUpdate($id)
    {

        self::checkAdmin();

        $category = Category::getCategoryById($id);

        $errors = [];

        if(isset($_POST['submit'])){

            $up_category = $_POST;

            if(!Category::updateCategory($up_category, $id)){
                $errors[] = 'Ошибка записи данных на сервер';

            } else {
                $_SESSION['status'] = 'Категория была успешно обнолвена!!!';
                redirect('/admin/category');
            }


        }

        require_once ROOT . '/views/admin_category/update.php';
        return true;
    }

    public function actionDelete($id)
    {
        if(isset($_POST['submit'])){
            if(Category::deleteCategory($id)){
                $_SESSION['status'] = 'Категория успешно удалена';
            } else {
                $errors[] = 'Не удалось удалить категорию с сервера';
            }

            redirect('/admin/category');
        }

        require_once ROOT . '/views/admin_category/delete.php';
        return true;
    }



}