<?php

class Cart
{
    public static function addProduct($id)
    {
        $id = intval($id);


        //Пустой массив для товаров в корзине:
        $productsInCart = [];

        //Если в корзине уже есть товары - они хранятся в сессии:
        if(isset($_SESSION['products'])) {
            //Заполняем массив товаров:
            $productsInCart = $_SESSION['products'];
        }

        //Если товаро есть в корзине, но был добавлен еще раз, увеличим количество:
        if(array_key_exists($id, $productsInCart)){
            $productsInCart[$id] ++;
        } else {
            //Добавляем новый товар в корзину:
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;

        return self::countItems();

    }

    /**
     * Удаление товара из корзины:
     *
     * @param $id
     */
    public static function deleteProduct($id)
    {
        unset($_SESSION['products'][$id]);
    }

    /**
     * Подсчет кол-ва товаров в корзине (в сессии)
     *
     * @return int
     */
    public static function countItems()
    {
        if(isset($_SESSION['products'])){
            $count = 0;
            foreach($_SESSION['products'] as $id => $qty){
                $count = $count + $qty;
            }
            return $count;
        } else {
            return 0;
        }
    }

    public static function getProducts()
    {
        if(isset($_SESSION['products'])) return $_SESSION['products'];
        return false;
    }

    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();

        if($productsInCart){
            $total = 0;
            foreach ($products as $product){
                $total += $product['price'] * $productsInCart[$product['id']];
            }

            return $total;
        }

        return false;
    }

    public static function clear()
    {
        if(isset($_SESSION['products'])) unset($_SESSION['products']);
    }

}