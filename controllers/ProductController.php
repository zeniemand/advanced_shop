<?php

//include_once ROOT . '/models/Category.php';
//include_once ROOT . '/models/Product.php';

class ProductController
{
    public function actionView($productId)
    {

        $categories = Category::getCategoriesList();

        $product = Product::getProductById($productId);

        //Определение колличества данного артикула в корзине пользоватлея:
        if(isset($_SESSION['products'][$product['id']])){
            $count_val = $_SESSION['products'][$product['id']];
        } else {
            $count_val = 0;
        }

        require_once ROOT . '/views/product/view.php';

        return true;
    }

}