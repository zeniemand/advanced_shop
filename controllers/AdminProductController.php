<?php

class AdminProductController extends AdminBase
{
    public function actionIndex()
    {

        //Проверка прав доступа:
        self::checkAdmin();

        $title = "Продукт - управление";

        //Получаем список товаров:
        $productsList = Product::getProductsList();

        //dd($productsList);

        require_once ROOT . '/views/admin_product/index.php';

        return true;
    }

    /**
     * Удаление товара по айди
     *
     * @param $id
     * @return bool
     */
    public function actionDelete($id)
    {
        //Проверка прав доступа:
        self::checkAdmin();

        //Обработка формы:
        if(isset($_POST['submit'])){
            //Удаляем товар:
            Product::deleteProductById($id);

            //Перенаправляем на страницу управления товарами:
            redirect('/admin/product');
        }

        require_once ROOT .  '/views/admin_product/delete.php';
        return true;
    }

    /**
     * Добавление товара
     *
     * @return bool
     */
    public function actionCreate()
    {
        //Проверка прав доступа:
        self::checkAdmin();

        //Получаем список категорий для выпадающего списка:
        $categoriesList = Category::getCategoriesListAdmin();

        //Обработка формы:
        if(isset($_POST['submit'])){

            //dd($_POST);

            //получаем данные из формы и размещаем их в массиве options:
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            //dd($options);

            //Флаг ошибок в форме:
            $errors = false;

            //Валидация поля имени:
            if(!isset($options['name']) || empty($options['name'])){
                $errors[] = 'Заполните поле имени';
            }

            if($errors == false){

                //dd($errors);
                //добавляем новый товар:
                $id = Product::createProduct($options);

                //dd($id);
                //Если запись добавлена:
                if($id){
                    //Проверим загружалось ли через форму изображение:
                    if(is_uploaded_file($_FILES['image']['tmp_name'])){
                        //Сохраним его в нужную нам папку с нужным именем:
                        move_uploaded_file($_FILES['image']['tmp_name'], ROOT . "/upload/images/{$id}.jpg");

                    }
                }
            }



        }

        require_once ROOT . '/views/admin_product/create.php';
        return true;
    }

    /**
     * Редактирование товара
     *
     * @return bool
     */
    public function actionUpdate($id)
    {
        //проверка прав доступа:
        self::checkAdmin();

        //Получаем список категорий для выпадающего списка:
        $categoriesList = Category::getCategoriesListAdmin();

        //Получаем данные о редактируемом товаре:
        $product = Product::getProductById($id);

        //dd($product);

        //Обработка формы:
        if(isset($_POST['submit'])){

            //dd($_POST);

            //получаем данные из формы и размещаем их в массиве options:
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            //dd($options);

            //Обновляем данные по товару:
            if(Product::updateProductById($id, $options)){
                //Проверим загружалось ли через форму изображение:
                if(is_uploaded_file($_FILES['image']['tmp_name'])){
                    //Сохраним его в нужную нам папку с нужным именем:
                    move_uploaded_file($_FILES['image']['tmp_name'], ROOT . "/upload/images/{$id}.jpg");

                }
                //Перенаправляем пользователя на страницу управления товарами:
                redirect('/admin/product');
            }

        }

        require_once ROOT . '/views/admin_product/update.php';
        return true;
    }

}