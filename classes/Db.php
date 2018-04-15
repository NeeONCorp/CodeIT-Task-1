<?php
class Db {
    public static function getConnection()
    {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);

        $dsn = 'mysql:host=' . $params['host'] . ';dbname=' . $params['db'] . ';charset=' . $params['charset'];
        $opt = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $pdo = new PDO($dsn, $params['user'], $params['pass'], $opt);
        } catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }

        return $pdo;
    }
}