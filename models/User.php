<?php

class User
{

    /**
     * Проверяет логин на валидность
     *
     * @param $login
     *
     * @return bool
     */
    private static function checkValidLogin($login)
    {
        if (mb_strlen($login, 'UTF-8') > 2
            && mb_strlen($login, 'UTF-8') <= 20
        ) {

            if (preg_match('~^[0-9a-z_-]+$~i', $login)) {
                return true;
            }

        }

        return false;
    }


    /**
     * Проверяет email на валидность
     *
     * @param $email
     *
     * @return bool
     */
    private static function checkValidEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }


    /**
     * Проверяет имя пользователя на валидность
     *
     * @param $name
     *
     * @return bool
     */
    private static function checkValidName($name)
    {
        if (mb_strlen($name) >= 2 && mb_strlen($name) <= 50) {
            if (preg_match('~^[a-zа-яёії]+([ ]([a-zа-яёії])+)?([ ]([a-zа-яёії])+)?$~ui',
                $name)
            ) {

                return true;
            }
        }

        return false;
    }


    /**
     * Проверяет дату рождения
     * Формат входной даты: 30/12/2000
     *
     * @param $dateBirth
     *
     * @return bool
     */
    private static function checkDateBirth($dateBirth)
    {
        if (preg_match('~^[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}$~', $dateBirth)) {
            $dateBirth    = str_replace('/', '-', $dateBirth);
            $dateBirthArr = explode('-', $dateBirth);
            $dateToday    = date('d-m-Y', time());

            if (checkdate($dateBirthArr[1], $dateBirthArr[0],
                $dateBirthArr[2])
            ) {
                if (strtotime($dateToday) > strtotime($dateBirth)) {
                    return true;
                }

            }
        }

        return false;
    }


    /**
     * Проверяет принял ли пользователь правила при регистрации
     *
     * @param $str
     *
     * @return bool
     */
    private static function checkAcceptRules($str)
    {
        if ($str === 'true') {
            return true;
        }

        return false;
    }

    /**
     * Проверяет уникальность заданного атрибута из таблицы users
     *
     * @param $attr
     * @param $value
     *
     * @return bool
     */
    private static function checkUniqueAttr($attr, $value)
    {
        $db    = Db::getConnection();
        $query = $db->prepare('SELECT COUNT(*) AS count FROM users WHERE '
                              . $attr . ' = ?');
        $query->execute([$value]);

        $count = $query->fetch();
        $count = $count['count'];

        if ($count > 0) {
            return false;
        }

        return true;
    }


    /**
     * Проверяет валидность пароля
     *
     * @param $password
     *
     * @return bool
     */
    private static function checkValidPassword($password)
    {
        if (mb_strlen($password, 'UTF-8') >= 6) {
            return true;
        }

        return false;
    }


    /**
     * Проверяет данные пользователя при регистрации
     *
     * @param $login
     * @param $email
     * @param $name
     * @param $password
     * @param $dateBirth
     * @param $cityId
     * @param $acceptRules
     *
     * @return bool|mixed
     */
    public static function checkDataRegistration(
        $login,
        $email,
        $name,
        $password,
        $dateBirth,
        $cityId,
        $acceptRules
    ) {
        $errors = [];

        if ( ! self::checkValidLogin($login)) {
            $errors[]
                = 'Логин введен неверно. Доступные символы: цифры, буквы латинского алфафита, \'-_\'. Минимальная длинна: 3 символа.';
        }
        if ( ! self::checkUniqueAttr('login', $login)) {
            $errors[] = 'Данный логин уже зарегистрирован в системе.';
        }
        if ( ! self::checkValidEmail($email)) {
            $errors[] = 'Email введен неверно.';
        }
        if ( ! self::checkUniqueAttr('email', $email)) {
            $errors[] = 'Данный email уже зарегистрирован в системе.';
        }
        if ( ! self::checkValidName($name)) {
            $errors[]
                = 'Имя введено некорректно. Поле должно содержать только символы кириллицы/латиницы. Пример правильного заполнения: Ян, Кобренко Владислав Серргеевич.';
        }
        if ( ! self::checkValidPassword($password)) {
            $errors[]
                = 'Минимальная длина пароля должна составлять 6 символов.';
        }
        if ( ! self::checkDateBirth($dateBirth)) {
            $errors[]
                = 'Некорректная дата рождения. Обратите внимание, что она должна быть меньше сегодняшней даты.';
        }
        if ( ! City::existCityById($cityId)) {
            $errors[] = 'Выбранный город больше недоступен для записи.';
        }
        if ( ! self::checkAcceptRules($acceptRules)) {
            $errors[]
                = 'Для регистрации необходимо принять условия использования.';
        }

        if (count($errors) > 0) {
            return $errors[0];
        }

        return true;
    }


    /**
     * Регистрирует пользователя
     *
     * @param $login
     * @param $email
     * @param $name
     * @param $password
     * @param $dateBirth
     * @param $cityId
     *
     * @return int|false
     */
    public static function registration(
        $login,
        $email,
        $name,
        $password,
        $dateBirth,
        $cityId
    ) {
        # Разбить дату на массив
        $dateBirth = explode('/', $dateBirth);

        # Зашифровать пароль
        $password = password_hash($password, PASSWORD_DEFAULT);

        $db    = Db::getConnection();
        $query = $db->prepare('INSERT INTO users 
                (email, login, password, name, year_birth, month_birth, day_birth, 
                id_city, timestamp_registration) 
                VALUES 
                (:email, :login, :password, :name, :year_birth, :month_birth,
                :day_birth, :id_city, :timestamp)');

        $result = $query->execute([
            'email'       => $email,
            'login'       => $login,
            'password'    => $password,
            'name'        => $name,
            'year_birth'  => $dateBirth[2],
            'month_birth' => $dateBirth[1],
            'day_birth'   => $dateBirth[0],
            'id_city'     => $cityId,
            'timestamp'   => time(),
        ]);

        if($result) {
            return $db->lastInsertId();
        }

        return false;
    }


    /**
     * Возвращает Id пользователя или перенаправляет его на страницу входа
     * (в случае если он не авторизован)
     *
     * @return int
     */
    public static function getId()
    {
        if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] > 0) {
            return intval($_SESSION['user']['id']);
        }

        header('Location: ../login');
        die();
    }


    /**
     * Проверяет является ли пользователь гостем
     *
     * @return boolean
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] > 0) {
            return false;
        }

        return true;
    }

    /**
     * Авторизует пользователя с заданным Id
     *
     * @param $id
     */
    public static function auth($id)
    {
        $_SESSION['user']['id'] = intval($id);
    }


    /**
     * Проверяет существует ли пользователь с заданными данными. В случае удачи
     * вернет Id пользователя.
     *
     * $identifier может содержать email или login
     *
     * @param $identifier
     * @param $password
     *
     * @return int|false
     */
    public static function checkDataLogin($identifier, $password)
    {
        # Получаем тип идентификатора
        $identifierType = 'login';

        if (self::checkValidEmail($identifier)) {
            $identifierType = 'email';
        }

        $db = Db::getConnection();
        $query
            = $db->prepare('SELECT COUNT(*) as count, id, password FROM users WHERE '
                           . $identifierType . ' = ?');
        $query->execute([$identifier]);

        $result = $query->fetch();
        $count  = $result['count'];

        if ($count > 0) {
            if (password_verify($password, $result['password'])) {
                return $result['id'];
            }
        }

        return false;
    }


    /**
     * Возвращает массив с данными о пользователе
     *
     * @param $id
     *
     * @return array
     */
    public static function getUserById($id)
    {
        $db    = Db::getConnection();
        $query = $db->prepare('SELECT 
                                         users.name, 
                                         users.email,
                                         users.login,
                                         users.year_birth,
                                         users.month_birth,
                                         users.day_birth,
                                         users.id_city,
                                         cities.name as city_name  
                                         FROM users
                                         LEFT JOIN cities ON users.id_city = cities.id
                                         WHERE users.id = :id');
        $query->execute(['id' => $id]);

        $result = $query->fetch();

        return $result;
    }

    /**
     * Уничтожает сессию пользователя
     */
    public static function logout() {
        if(isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
    }
}