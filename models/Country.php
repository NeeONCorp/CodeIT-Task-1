<?php

class Country
{

    /**
     * Проверить существование страны с указанным Id
     *
     * @param $id
     *
     * @return bool
     */
    public static function existCountryById($id)
    {
        $db = Db::getConnection();
        $query
            = $db->prepare('SELECT COUNT(*) as count FROM countries WHERE id = :id');
        $query->execute(['id' => $id]);

        $count = $query->fetch();
        $count = $count['count'];

        if ($count > 0) {
            return true;
        }

        return false;
    }

    /**
     * Возвращает массив со списком активных стран
     *
     * @return array
     */
    public static function getCountriesList()
    {
        $db = Db::getConnection();
        $query = $db->query('SELECT id, name FROM countries WHERE status != 0');

        $result = $query->fetchAll();

        return $result;
    }
}