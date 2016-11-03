<?php

function paint_template_error($message)
{
    $log = Log::getInstance();
    $log->add_log_general('error paint_template_error', 'products', 'response'.http_response_code()); //$text, $controller, $function
    $log->add_log_user('error paint_template_error', '', 'products', 'response'.http_response_code()); //$msg, $username = "", $controller, $function

    $arrData = response_code(http_response_code());

    echo "<div id='page'>";
    echo '<br><br>';
    echo "<div id='header' class='status4xx'>";
    //https://es.wikipedia.org/wiki/Anexo:C%C3%B3digos_de_estado_HTTP
    echo '<h1>'.$message.'</h1>';
    echo '</div>';
    echo "<div id='content'>";
    echo '<h2>The following error occurred:</h2>';
    echo '<p>The requested URL was not found on this server.</p>';
    echo '<P>Please check the URL or contact the <!--WEBMASTER//-->webmaster<!--WEBMASTER//-->.</p>';
    echo '</div>';
    echo "<div id='footer'>";
    echo "<p>Powered by <a href='http://www.ispconfig.org'>ISPConfig</a></p>";
    echo '</div>';
    echo '</div>';
}

function paint_template_products($arrData)
{
    // NO ME FUNCIONA ASÏ EL SCRIPT Lo Inserto en el Header
    //echo "<script type='text/javascript' src='modules/products_front_end/view/js/modal_products.js' ></script>";

    echo '<section >';
    echo "<div class='container'>";
    echo "<div id='list_prod' class='row text-center pad-row'>";
    echo "<ol class='breadcrumb'>";
    echo "<li class='active' >Products</li>";
    echo '</ol>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    if (isset($arrData) && !empty($arrData)) {
        foreach ($arrData as $product) {
            echo "<div class='prod' id='".$product['Codigo']."'>";
            echo "<img class='prodImg' src='".$product['Imagen']."'alt='product' >";
            echo '<p>'.$product['Titulo'].'</p>';
            echo "<p id='p2'>".$product['Precio'].'€</p>';
            echo '</div>';
        }
    }
    echo '</div>';
    echo '</div>';
    echo '</section>';
}
