<?php

include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/utils/response_code.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/utils/filters.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/utils/common.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/classes/Log.class.singleton.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/paths.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/model/Conf.class.singleton.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/modules/products_front_end/utils/utils.inc.php';

//include SITE_ROOT.'modules/products/utils/utils.inc.php';

$_SESSION['module'] = 'products_front_end';

//PARTE NUEVA

if ((isset($_GET['autocomplete'])) && ($_GET['autocomplete'] === 'true')) {
    set_error_handler('ErrorHandler');
    $path_model = $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/modules/products_front_end/model/model/';
      //echo json_encode($path_model);
    try {
        $nameProducts = loadModel($path_model, 'products_front_end_model', 'select_column_products', 'Titulo');
        //echo json_encode($nameProducts);
    } catch (Exception $e) {
        showErrorPage(2, 'ERROR - 503 BD', 'HTTP/1.0 503 Service Unavailable', 503);
    }
    restore_error_handler();

    if ($nameProducts) {
        $jsondata['nom_productos'] = $nameProducts;
        echo json_encode($jsondata);
        exit;
    } else {
        showErrorPage(2, 'ERROR - 404 NO DATA', 'HTTP/1.0 404 Not Found', 404);
    }
}

if (($_GET['nombre_cuadro'])) {
    //filtrar $_GET["nom_product"]

    $result = filter_string($_GET['nombre_cuadro']);
    if ($result['resultado']) {
        $criteria = $result['datos'];
    } else {
        $criteria = '';
    }
    $path_model = $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/modules/products_front_end/model/model/';
    set_error_handler('ErrorHandler');
    try {
        $arrArgument = array(
            'column' => 'Titulo',
            'like' => $criteria,
        );
        $producto = loadModel($path_model, 'products_front_end_model', 'select_like_products', $arrArgument);

        //throw new Exception(); //que entre en el catch
    } catch (Exception $e) {
        showErrorPage(2, 'ERROR - 503 BD', 'HTTP/1.0 503 Service Unavailable', 503);
    }
    restore_error_handler();

    if ($producto) {
        $jsondata['product_autocomplete'] = $producto;
        echo json_encode($jsondata);
        exit;
    } else {
        //if($producto){{ //que lance error si no existe el producto
        showErrorPage(2, 'ERROR - 404 NO DATA', 'HTTP/1.0 404 Not Found', 404);
    }
}
///////////////////mes parts////////////

if (($_GET['total_products'])) {
    //filtrar $_GET["count_product"]
    $result = filter_string($_GET['total_products']);
    if ($result['resultado']) {
        $criteria = $result['datos'];
    } else {
        $criteria = '';
    }
    $path_model = $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/modules/products_front_end/model/model/';
    set_error_handler('ErrorHandler');
    try {
        $arrArgument = array(
            'column' => 'Titulo',
            'like' => $criteria,
        );
        $total_rows = loadModel($path_model, 'products_front_end_model', 'count_like_products', $arrArgument);
        //throw new Exception(); //que entre en el catch
    } catch (Exception $e) {
        showErrorPage(2, 'ERROR - 503 BD', 'HTTP/1.0 503 Service Unavailable', 503);
    }
    restore_error_handler();

    if ($total_rows) {
        $jsondata['num_products'] = $total_rows[0]['total'];
        echo json_encode($jsondata);
        exit;
    } else {
        //if($total_rows){ //que lance error si no existe el producto
        showErrorPage(2, 'ERROR - 404 NO DATA', 'HTTP/1.0 404 Not Found', 404);
    }
}

if ((isset($_GET['num_pages'])) && ($_GET['num_pages'] === 'true')) {
    //filtrar $_GET["keyword"]
    if (isset($_GET['keyword'])) {
        $result = filter_string($_GET['keyword']);
        if ($result['resultado']) {
            $criteria = $result['datos'];
        } else {
            $criteria = '';
        }
    } else {
        $criteria = '';
    }
    $item_per_page = 6;
    $path_model = $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/modules/products_front_end/model/model/';
    set_error_handler('ErrorHandler');
    try {
        //loadmodel
        $arrArgument = array(
            'column' => 'Titulo',
            'like' => $criteria,
        );

        $resultado = loadModel($path_model, 'products_front_end_model', 'count_like_products', $arrArgument);

        $resultado = $resultado[0]['total'];
        $jsondata['column'] = $resultado;
        $pages = ceil($resultado / $item_per_page); //break total records into pages
    } catch (Exception $e) {
        showErrorPage(2, 'ERROR - 503 BD', 'HTTP/1.0 503 Service Unavailable', 503);
    }
    restore_error_handler();

    if ($resultado) {
        $jsondata['pages'] = $pages;
        echo json_encode($jsondata);
        exit;
    } else {
        //if($get_total_rows){ //que lance error si no hay productos
        showErrorPage(2, 'ERROR - 404 NO DATA', 'HTTP/1.0 404 Not Found', 404);
    }
}

if ((isset($_GET['view_error'])) && ($_GET['view_error'] === 'true')) {
    /* paint_template_error("ERROR BD");
      die(); */
    showErrorPage(0, 'ERROR - 503 BD Unavailable', 503);
}
if ((isset($_GET['view_error'])) && ($_GET['view_error'] === 'false')) {
    //showErrorPage(0, "ERROR - 404 NO PRODUCTS");
    showErrorPage(3, 'RESULTS NOT FOUND <br> Please, check over if you misspelled any letter of the search word');
}

if (isset($_GET['cod_cuadro'])) {
    //$arrValue = null;

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
    if (isset($_POST['page_num'])) {
        $result = filter_num_int($_POST['page_num']);
        if ($result['resultado']) {
            $page_number = $result['datos'];
        }
    } else {
        $page_number = 1;
    }

    $item_per_page = 6;

    if (isset($_GET['keyword'])) {
        $result = filter_string($_GET['keyword']);
        if ($result['resultado']) {
            $criteria = $result['datos'];
        } else {
            $criteria = '';
        }
    } else {
        $criteria = '';
    }

    if (isset($_POST['keyword'])) {
        $result = filter_string($_POST['keyword']);
        if ($result['resultado']) {
            $criteria = $result['datos'];
        } else {
            $criteria = '';
        }
    }

    $position = (($page_number - 1) * $item_per_page);
    $path_model = $_SERVER['DOCUMENT_ROOT'].'/php/marvelArte_ORM_4/1_bs_multipurpose_Ruma/modules/products_front_end/model/model/';
    $limit = $item_per_page;
    $arrArgument = array(
        'column' => 'Titulo',
        'like' => $criteria,
        'position' => $position,
        'limit' => $limit,
    );
    set_error_handler('ErrorHandler');
    try {
        $resultado = loadModel($path_model, 'products_front_end_model', 'select_like_limit_products', $arrArgument);
    } catch (Exception $e) {
        /* paint_template_error("ERROR BD");
          die(); */

        showErrorPage(0, 'ERROR - 503 BD Unavailable', 503);
    }
    restore_error_handler();

    if ($resultado) {
        paint_template_products($resultado);
    } else {
        //paint_template_error("NO PRODUCTS");
        showErrorPage(0, 'ERROR - 404 NO PRODUCTS', 404);
    }
}
