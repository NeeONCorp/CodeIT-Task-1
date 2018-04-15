<?php

class AppController extends App
{

    /**
     * Главная страница
     */
    public function actionIndex()
    {
        # Заголовок страницы
        self::$page['title'] = 'Главная';

        include_once(ROOT . '/views/app/index.php');
    }


    /**
     * Страница 404
     */
    public function actionPage404()
    {
        # Заголовок страницы
        self::$page['title'] = 'Страница 404';

        include_once(ROOT . '/views/app/404.php');
    }
}