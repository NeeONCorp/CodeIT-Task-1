<?php

class City
{

    /**
     * Проверить существование города с указанным Id
     *
     * @param $id
     *
     * @return bool
     */
    public static function existCityById($id)
    {
        $db = Db::getConnection();
        $query
            = $db->prepare('SELECT COUNT(*) as count FROM cities WHERE id = :id');
        $query->execute(['id' => $id]);

        $count = $query->fetch();
        $count = $count['count'];

        if ($count > 0) {
            return true;
        }

        return false;
    }

    /**
     * Возвращает массив со списком активных городов
     *
     * @return array
     */
    public static function getCitiesList()
    {
        $db = Db::getConnection();
        $query = $db->query('SELECT id, name FROM cities WHERE status != 0');

        $result = $query->fetchAll();

        return $result;
    }
}