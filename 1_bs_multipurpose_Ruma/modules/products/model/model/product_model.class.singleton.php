<?php

require SITE_ROOT.'modules/products/model/BLL/product_bll.class.singleton.php';

class product_model
{
    private $bll;
    public static $_instance;

    private function __construct()
    {
        $this->bll = product_bll::getInstance();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function create_product($arrArgument)
    {
        return $this->bll->create_product_BLL($arrArgument);
    }

    public function obtain_paises($url)
    {
        return $this->bll->obtain_paises_BLL($url);
    }

    public function obtain_provincias()
    {
        return $this->bll->obtain_provincias_BLL();
    }

    public function obtain_poblaciones($arrArgument)
    {
        return $this->bll->obtain_poblaciones_BLL($arrArgument);
    }
}
