<?php

class UserController extends App
{

    /**
     * Страница входа в аккаунт
     */
    function actionPageLogin()
    {
        # Проверить является ли пользователь гостем
        if ( ! User::isGuest()) {
            header('Location: ./account');
        }

        # Заголовок страницы
        self::$page['title'] = 'Авторизация';

        include_once ROOT . '/views/user/login.php';
    }

    /**
     * Страница регистрации пользователей
     */
    function actionPageRegistration()
    {
        # Проверить является ли пользователь гостем
        if ( ! User::isGuest()) {
            header('Location: ./account');
        }

        # Получить список стран
        $countriesArr = Country::getCountriesList();

        # Заголовок страницы
        self::$page['title'] = 'Регистрация';

        include_once ROOT . '/views/user/registration.php';
    }

    /**
     * Регистрация пользователя
     */
    function actionAjaxRegistration()
    {
        # Проверить корректность данных
        $checkData = call_user_func_array(['User', 'checkDataRegistration'],
            $_POST);

        # Зарегистрировать пользователя
        if ($checkData === true) {
            unset($_POST['rules']);
            $userId = call_user_func_array(['User', 'registration'], $_POST);

            if($userId !== false && $userId > 0) {
                User::auth($userId);
            }
        }

        # Ответ
        if ($checkData === true) {
            echo 'success';
        } else {
            echo $checkData;
        }
    }

    /**
     * Авторизация пользователя
     */
    function actionAjaxLogin()
    {
        $identifier = $_POST['identifier'];
        $password   = $_POST['password'];

        # Проверить корректность данных пользователя
        $userId = User::checkDataLogin($identifier, $password);

        if ($userId > 0) {
            User::auth($userId);
            echo 'success';
        } else {
            echo 'Email/логин или пароль некорректный.';
        }
    }
}