<?php

class AdminController extends AdminBase
{
    /**
     * Вывод стартовой страницы панели администратора
     *
     * @return bool
     */
    public function actionIndex()
    {
        //Проверка прав доступа:
        $this->checkAdmin();

        require_once ROOT . '/views/admin/index.php';

        return true;
    }

}