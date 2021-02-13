<?php

class Product
{
    //Limit показываемых товаров.
    const SHOW_BY_DEFAULT = 3;

    /**
     * Получить массив данных по последним товароам:
     *
     * @param int $count
     * @return array
     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
    {
        $count = intval($count);

        $db = DB::getConnection();

        $productList = array();

        $result = $db->query('SELECT `id`, `name`, `image_id`, `price`,  `is_new` FROM product '
        . 'WHERE status = 1 '
        . 'ORDER BY id DESC '
        . 'LIMIT ' . $count);


        $i = 0;

        while($row = $result->fetch()){
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['image_id'] = $row['image_id'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productList;

    }

    /**
     * Получить массив данных рекомендуемых товаров:
     *
     * @return array
     */
    public static function getRecommendedProducts()
    {

        $db = DB::getConnection();

        $productList = array();

        $sql = 'SELECT `id`, `name`, `image_id`, `price`,  `is_new` FROM product '
            . 'WHERE is_recommended = 1 '
            . 'ORDER BY id DESC ';

        //dd($sql);
        $result = $db->query($sql);


        $i = 0;

        while($row = $result->fetch()){
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['image_id'] = $row['image_id'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productList;

    }

    /**
     * Поулчить полный список товаров в конкретной категории
     *
     * @param bool $categoryId
     * @param int $page
     * @return array
     */
    public static function getProductsListByCategory($categoryId = false, $page = 1)
    {

        if($categoryId){

            $page = intval($page);

            //вычисляем OFFSET для SQL запроса в БД.
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

            $db = Db::getConnection();
            $products = array();
            $result = $db->query("SELECT id, `name`, price, image_id, is_new FROM product  "
            . "WHERE status = '1' AND category_id = $categoryId "
            . "ORDER BY id DESC "
            . "LIMIT " . self::SHOW_BY_DEFAULT
            . " OFFSET " . $offset);

            $i = 0;

            while($row = $result->fetch()){

                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['image_id'] = $row['image_id'];
                $products[$i]['is_new'] = $row['is_new'];
                $i++;
            }

            return $products;
        }

    }


    /**
     * Получить данные товара по его id
     *
     * @param $id
     * @return mixed
     */
    public static function getProductById($id)
    {


        $id = intval($id);


        if ($id) {

            $db = Db::getConnection();

            $result = $db->query("SELECT * FROM product  "
                . "WHERE id = $id ");

            $result->setFetchMode(PDO::FETCH_ASSOC);

            return $result->fetch();
        }
    }

    /**
     * Поулчить число товаров конкретной категории
     *
     * @param $categoryId
     * @return mixed
     */
    public static function getTotalProductListInCategory($categoryId)
    {
        $db = DB::getConnection();

        $sql = "SELECT count(id) AS count FROM product "
            . " WHERE status= 1 AND category_id = $categoryId ";

        //dd($sql);

        $result = $db->query($sql);

        $row = $result->fetch(PDO::FETCH_ASSOC);

        return $row['count'];
    }

    /**
     * Получить массив товаров по их айди
     *
     * @param $idsArray
     * @return array
     */
    public static function getProductsByIds($idsArray)
    {
        $products = [];

        $db = DB::getConnection();

        //превращаем в строку ids, чтобы удобно в запрос передавать было:
        $idsString = implode(',', $idsArray);

        $sql = "SELECT * FROM product WHERE status = '1' AND id IN ($idsString)";

        $result = $db->query($sql);

        $i = 0;

        while($row = $result->fetch(PDO::FETCH_ASSOC)){

            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['code'] = $row['code'];
            $i++;
        }

        return $products;
    }

    /**
     * Возвращает массив с данными по всем товарам.
     *
     * @return array
     */
    public static function getProductsList()
    {
        $db = DB::getConnection();

        $sql = "SELECT id, name, code, price FROM product";

        $result = $db->query($sql);

        $productsList = array();
        $i = 0;

        while($row = $result->fetch()){
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['code'] = $row['code'];
            $productsList[$i]['price'] = $row['price'];
            $i++;
        }

        return $productsList;
    }

    /**
     * Удаление товара по айди
     *
     * @param $id
     * @return bool
     */
    public static function deleteProductById($id)
    {
        $db = DB::getConnection();

        $sql = "DELETE FROM product WHERE id = :id";


        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Добавление записи в табличку product
     *
     * @param $options - значения параметров запроса
     *
     * @return int id добавленной записи либо 0
     */
    public static function createProduct($options)
    {
        //dd($options);

        //Получаем соединение с БД:
        $db = DB::getConnection();

        $sql = 'INSERT INTO product '
            . '(name, code, price, category_id, brand, availability,'
            . 'description, is_new, is_recommended, status)'
            . 'VALUES '
            . '(:name, :code, :price, :category_id, :brand, :availability,'
            . ':description, :is_new, :is_recommended, :status)';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);




        if($result->execute()){
            //Если запрос выполнен удачно, то возвращаем id добавленной записи:
            return $db->lastInsertId();
        }

        return 0;
    }

    /**
     * Редактирование записи в табличке product
     *
     * @param $id - идентификатор редактируемого товара
     * @param $options - значения параметров запроса
     *
     * @return int id добавленной записи либо 0
     */
    public static function updateProductById($id, $options)
    {
        //Устанавливаем соединение с БД:
        $db = DB::getConnection();

        //dd($id);
        //dd($options);
        //Формируем запрос:
        $sql = "UPDATE product SET "
             . "name = :name, "
             . "code = :code, "
             . "price = :price, "
             . "category_id = :category_id, "
             . "brand = :brand, "
             . "availability = :availability, "
             . "description = :description, "
             . "is_new = :is_new, "
             . "is_recommended = :is_recommended, "
             . "status = :status "
             . "WHERE id = :id";

        //dd($sql);

        //Создаем подготовленный запрос PDOStatement:
        $result = $db->prepare($sql);
        //Связываем параметры с полученными данными:
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        //Возвращаем результат выполненного запроса:
        return $result->execute();

    }

    /**
     * Возвращает список товаров с указанными индентификторами
     * @param array $idsArray <p>Массив с идентификаторами</p>
     * @return array <p>Массив со списком товаров</p>
     */
    public static function getProdustsByIds($idsArray)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Превращаем массив в строку для формирования условия в запросе
        $idsString = implode(',', $idsArray);

        // Текст запроса к БД
        $sql = "SELECT * FROM product WHERE status='1' AND id IN ($idsString)";

        $result = $db->query($sql);

        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // Получение и возврат результатов
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }
        return $products;
    }

    /**
     * Возвращает путь к изображению
     */
    public static function getImage($id)
    {
        // Название изображения-пустышки
        $noImage = 'no-image.jpg';

        // Путь к папке с товарами
        $path = '/upload/images/';

        // Путь к изображению товара
        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            // Если изображение для товара существует
            // Возвращаем путь изображения товара
            return $pathToProductImage;
        }

        // Возвращаем путь изображения-пустышки
        return $path . $noImage;
    }

}