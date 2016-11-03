<?php

include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/utils/response_code.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/utils/filters.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/utils/common.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/classes/Log.class.singleton.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/paths.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/model/Conf.class.singleton.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/modules/products_front_end/utils/utils.inc.php';

include(SITE_ROOT . "modules/products/utils/utils.inc.php");

$_SESSION['module'] = 'products_front_end';

//obtain num total pages
if ((isset($_GET['num_pages'])) && ($_GET['num_pages'] === 'true')) {
    $item_per_page = 3;
    $path_model = $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/modules/products_front_end/model/model/';
    //change work error apache
    set_error_handler('ErrorHandler');

    try {
        //throw new Exception();
        $arrValue = loadModel($path_model, 'products_front_end_model', 'total_products');
        $get_total_rows = $arrValue[0]['total']; //total records
        $pages = ceil($get_total_rows / $item_per_page); //break total records into pages
    } catch (Exception $e) {
        //echo json_encode($e);
        showErrorPage(2, 'ERROR - 503 BD', 'HTTP/1.0 503 Service Unavailable', 503);
    }

    //change to defualt work error apache
    restore_error_handler();

    if ($get_total_rows) {
        $jsondata['pages'] = $pages;
        echo json_encode($jsondata);
        exit;
    } else {
        showErrorPage(2, 'ERROR - 404 NO DATA', 'HTTP/1.0 404 Not Found', 404);
    }
}

if ((isset($_GET['view_error'])) && ($_GET['view_error'] === 'true')) {
    showErrorPage(0, 'ERROR - 503 BD Unavailable');
}
if ((isset($_GET['view_error'])) && ($_GET['view_error'] === 'false')) {
    showErrorPage(0, 'ERROR - 404 NO DATA');
}

if (isset($_GET['cod_cuadro'])) {
    $arrValue = null;
    //filter if idProduct is a number
    //$result = filter_num_int($_GET['cod_cuadro']);
    $result = $_GET['cod_cuadro'];
    /*if ($result['resultado']) {
        $id = $result['datos'];
    } else {
        $id = 1;
    }*/

    set_error_handler('ErrorHandler');
    try {
        //throw new Exception();
        $path_model = $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/modules/products_front_end/model/model/';
        $arrValue = loadModel($path_model, 'products_front_end_model', 'details_products', $result);
    } catch (Exception $e) {
        showErrorPage(2, 'ERROR - 503 BD', 'HTTP/1.0 503 Service Unavailable', 503);
    }
    restore_error_handler();

    if ($arrValue) {
        $jsondata['product'] = $arrValue[0];
        echo json_encode($jsondata);
        exit;
    } else {
        showErrorPage(2, 'ERROR - 404 NO DATA', 'HTTP/1.0 404 Not Found', 404);
    }
} else {
    $item_per_page = 3;

    //filter to $_POST["page_num"]
    if (isset($_POST['page_num'])) {
        $result = filter_num_int($_POST['page_num']);
        if ($result['resultado']) {
            $page_number = $result['datos'];
        }
    } else {
        $page_number = 1;
    }
    set_error_handler('ErrorHandler');
    try {
        $position = (($page_number - 1) * $item_per_page);

        $arrArgument = array(
            'position' => $position,
            'item_per_page' => $item_per_page,
        );

        $path_model = $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/modules/products_front_end/model/model/';
        $arrValue = loadModel($path_model, 'products_front_end_model', 'page_products', $arrArgument);
    } catch (Exception $e) {
        showErrorPage(0, 'ERROR - 503 BD Unavailable');
    }
    restore_error_handler();
    if ($arrValue) {
        paint_template_products($arrValue);
    } else {
        showErrorPage(0, 'ERROR - 404 NO PRODUCTS');
    }
}
