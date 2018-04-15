<?php

class App
{

    # Роль пользователя (гость/пользователь)
    public static $isGuest = false;

    # Заголовок страницы
    public static $page = ['title' => 'Неопознанная страница'];

    public function __construct()
    {
        if (User::isGuest()) {
            self::$isGuest = true;
        }
    }

    /**
     * Переадресация на страницу 404
     */
    public static function pageNotFount()
    {
        header('Location: /' . self::getDirUrl() . '/404');
        die();
    }


    /**
     *  Возвращает url директорию проекта
     *
     * @return string
     */
    public static function getDirUrl()
    {
        $file = explode('/', $_SERVER['PHP_SELF']);
        $file = end($file);

        $path = str_replace($file, '', $_SERVER['PHP_SELF']);
        $path = trim($path, '/');

        return $path;
    }
}