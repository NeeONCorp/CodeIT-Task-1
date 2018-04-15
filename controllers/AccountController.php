<?php

class AccountController extends App
{

    /**
     * Главная страница
     */
    public function actionIndex()
    {
        # Получить Id пользователя
        $userId = User::getId();

        # Получить данные пользователя
        $user = User::getUserById($userId);

        # Заголовок страницы
        self::$page['title'] = $user['name'];

        include_once ROOT . '/views/account/index.php';
    }

    /**
     * Выход из профиля
     */
    public static function actionLogout()
    {
        User::logout();
        header('Location: ../login');
    }
}