<?php

class listar_dao
{
    public static $_instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function list_products_DAO($db)
    {
        $sql = 'SELECT * FROM cuadros';
        $stmt = $db->ejecutar($sql);

        return $db->listar($stmt);
    }

    public function details_products_DAO($db, $id)
    {
        $sql = 'SELECT * FROM cuadros WHERE Codigo='."'".$id."'";
        $stmt = $db->ejecutar($sql);

        return $db->listar($stmt);
    }

    public function page_products_DAO($db, $arrArgument)
    {
        $position = $arrArgument['position'];
        $item_per_page = $arrArgument['item_per_page'];
        $sql = 'SELECT * FROM cuadros ORDER BY Codigo ASC LIMIT '.$position.' , '.$item_per_page;

        $stmt = $db->ejecutar($sql);

        return $db->listar($stmt);
    }

    public function total_products_DAO($db)
    {
        $sql = 'SELECT COUNT(*) as total FROM cuadros';
        $stmt = $db->ejecutar($sql);

        return $db->listar($stmt);
    }
}
