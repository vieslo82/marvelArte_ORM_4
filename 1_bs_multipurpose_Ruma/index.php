<?php
    ob_start();
    session_start();

    require_once 'view/inc/header.html';
    require_once 'view/inc/menu.php';
    include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/paths.php';
    include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/model/Conf.class.singleton.php';
    include 'utils/utils.inc.php';

    if (PRODUCTION) { //we are in production
        ini_set('display_errors', '1');
        ini_set('error_reporting', E_ERROR | E_WARNING | E_NOTICE); //error_reporting(E_ALL) ;
    } else {
        ini_set('display_errors', '0');
        ini_set('error_reporting', '0'); //error_reporting(0);
    }

    $_SESSION['module'] = '';
    $_SESSION['result_avatar'] = array();

    if (!isset($_GET['module'])) {
        require_once 'modules/main/controller/controller_main.class.php';
    } elseif ((isset($_GET['module'])) && (!isset($_GET['view']))) {
        require_once 'modules/'.$_GET['module'].'/controller/controller_'.$_GET['module'].'.class.php';
    }

    if ((isset($_GET['module'])) && (isset($_GET['view']))) {
        require_once 'modules/'.$_GET['module'].'/view/'.$_GET['view'].'.php';
    }

    require_once 'view/inc/footer.html';
