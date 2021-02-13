<?php


class SiteController
{
    /**
     * вывод главной страницы сайта
     *
     * @return bool
     */
    public function actionIndex()
    {
        //Получаем категории:
        $categories = Category::getCategoriesList();

        //Полуаем последные товары:
        $latestProducts = Product::getLatestProducts(6);

        //Получаем товары для слайдера:
        $sliderProducts = Product::getRecommendedProducts();

        require_once ROOT . '/views/site/index.php';

        return true;
    }

    /**
     * вывод страницы контактов
     *
     * @return bool
     */
    public function actionContact()
    {
        $userEmail = '';
        $userText = '';
        $result = false;

        // если заполнили и отправили форму обратной связи:
        if (isset($_POST['submit'])) {

            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            $errors = false;

            // Валидация полей
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Неправильный email';
            }

            if ($errors == false) {
                $adminEmail = 'admin@advanced-shop.loc';
                $message = "Текст: {$userText}. От {$userEmail}";
                //dd($message);
                $subject = 'Тема письма';
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }

        }

        require_once(ROOT . '/views/site/contact.php');

        return true;
    }


}