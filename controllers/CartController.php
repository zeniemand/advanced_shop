<?php

class CartController
{
    public function actionAdd($id)
    {
        //Добавляем товар в корзину:
        Cart::addProduct($id);

        //Возвращаем пользоватяеля на страницу:
        back();

    }

    public function actionAddAjax($id)
    {
        //Добавляем товар в корзину:
        echo Cart::addProduct($id);

        //Возвращаем пользоватяеля на страницу:
        //back();

        return true;

    }

    public function actionIndex()
    {
        $categories = Category::getCategoriesList();

        $productsInCart = false;

        //Получим данные из корзины:
        $productsInCart = Cart::getProducts();

        if($productsInCart){
            //Получим полную информацию о товарах для списка
            $productsIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productsIds);

            //Получим общую стоимость товаров:
            $totalPrice = Cart::getTotalPrice($products);
            //dd($totalPrice);
        }

        require_once ROOT . '/views/cart/index.php';

        return true;

    }

    /**
     * Удаление товара из корзины:
     *
     * @param $id
     */
    public function actionDelete($id)
    {
        Cart::deleteProduct($id);

        redirect('/cart/');
    }

    public function actionCheckout()
    {

        //Список категорий для левого меню:
        $categories = Category::getCategoriesList();

        //Статус успешного оформления заказа:
        $result = false;

        //Если форма отправлена:
        if(isset($_POST['submit'])){

            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            //>Валидация полей:
            $errors = false;
            if(!User::checkName($userName)) $errors[] = 'Неправильное имя';
            if(!User::checkPhone($userPhone)) $errors[] = 'Неправильный телефон';
            //<

            //Проверка корректности заполнения формы:
            if($errors == false){

                //>Собираем информацию о заказе:
                $productsInCart = Cart::getProducts();
                $userId = (User::isGuest()) ? false : User::checkLogged();
                //<

                //Сохраняем заказ в БД:
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                if($result){
                    /*

                    //Оповещаем администратора о новом заказе:
                    $adminEmail = 'admin@advanced-shop.loc';
                    $message = 'http://advanced-shop.loc/admin/orders';
                    $subject = 'Новый заказ';
                    mail($adminEmail, $subject, $message);

                    */

                    //Очищаем корзину:
                    Cart::clear();
                }

            } else {

                //>Собираем данные для передачи назад в вид в форму:
                $productsInCart = Cart::getProducts();
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
                //<

            }


        } else {
            //Если форма не отправлена:

            //Получаем данные из корзины:
            $productsInCart = Cart::getProducts();

            //Проверяем наличие товаров в корзине:
            if($productsInCart == false){
                //Возвращаем на главную страницу, чтобы скупился)):
                redirect('/');
            } else {

                //>Подсчитываем итоги закупок:
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);

                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
                //<

                //>В форму передаем пустые значения для полей:
                $userName = false;
                $userPhone = false;
                $userComment = false;
                //<

                //Если пользователь авторизирован, собираем его данные в форму:
                if(!User::isGuest()){
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);

                    $userName = $user['name'];
                }

            }
        }

        require_once ROOT . '/views/cart/checkout.php';

        return true;
    }

}