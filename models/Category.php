<?php


class Category
{
    /**
     * return array Categories with status = 1
     *
     */
    public static function getCategoriesList(){

        //Подключаемся к БД:
        $db = DB::getConnection();

        $categoruList = array();

        $sql = 'SELECT id, name FROM category '
            . ' WHERE status = "1" '
            . 'ORDER BY sort_order ASC';

        //dd($sql);

        $result = $db->query($sql);


        $i = 0;

        while($row = $result->fetch()){
            $categoruList[$i]['id'] = $row['id'];
            $categoruList[$i]['name'] = $row['name'];
            $i++;
        }

        return $categoruList;

    }

    /**
     * return array of all Categories
     *
     */
    public static function getCategoriesListAdmin(){

        //Подключаемся к БД:
        $db = DB::getConnection();

        $categoruList = array();

        $sql = 'SELECT id, name, sort_order, status FROM category '
            . 'ORDER BY sort_order ASC';

        //dd($sql);

        $result = $db->query($sql);

        $i = 0;

        while($row = $result->fetch()){
            $categoruList[$i]['id'] = $row['id'];
            $categoruList[$i]['name'] = $row['name'];
            $categoruList[$i]['sort_order'] = $row['sort_order'];
            $categoruList[$i]['status'] = $row['status'];
            $i++;
        }

        return $categoruList;

    }

    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Отображается';
                break;
            case '0':
                return 'Скрыта';
                break;
        }
    }

    public static function getCategoryById(int $id)
    {
        $db = DB::getConnection();

        $sql = "SELECT * FROM `category` WHERE id = $id";

        $stmt = $db->query($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetch();

        return $result;

    }

    public static function createCategory(array $options)
    {
        $db = DB::getConnection();

        //dd($options);


        $sql = "INSERT INTO `category` (`name`, `sort_order`, `status`) "
              ." VALUES (?, ?, ?)";

        //dd($sql);

        $stmt = $db->prepare($sql);
        if($stmt->execute([$options['name'], $options['sort_order'], $options['status']])) return $db->lastInsertId();

        return false;

    }

    public static function updateCategory(array $options, int $id): bool
    {
        $db = DB::getConnection();

        //debug(['options' => $options]);

        $sql = "UPDATE `category` SET `name` = ?, `sort_order` = ?, `status` = ? WHERE `id` = ?";

        //dd($sql);
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            $options['name'],
            $options['sort_order'],
            $options['status'],
            $id
        ]);
    }

    public static function deleteCategory(int $id)
    {
        $db = DB::getConnection();

        $sql = "DELETE FROM `category` WHERE id=$id";
        return $stmt = $db->query($sql);

    }



}