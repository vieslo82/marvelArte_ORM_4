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

    echo '<script type="text/javascript" src="modules/products_front_end/view/js/modal_products_2.js" ></script>';
    echo '<section id="services" >';
    echo '<div class="container">';

    echo '<div class="table-display">';

    if (isset($arrData) && !empty($arrData)) {
        $i = 0;
        foreach ($arrData as $product) {
            ++$i;
            if (count($arrData) % 2 !== 0 && i >= count($arrData)) {
                print  '<div class="odd_prod">';
            } else {
                if ($i % 2 != 0) {
                    print  '<div class="table-row">';
                } else {
                    print '<div class="table-separator"></div>';
                }
            }
            echo '<div class="table-cell">';

            echo '<div class="media">';
            echo '<div class="pull-left">';
            echo '<img src="'.$product['Imagen'].'" class="icon-md" height="80" width="80">';
            echo '</div>';
            echo '<div class="media-body">';
            echo '<h3 class="media-heading">'.$product['Titulo'].'</h3>';
            echo '<h5> <strong>Precio:'.$product['Precio'].'</strong><strong>€</strong> </h5>';
            echo "<div id='".$product['Codigo']."' class='product_name'> Read Details </div>";

            echo '</div>';
            echo '</div>';
            echo '<br>';

            echo '</div>';
            if (count($arrData) % 2 !== 0 && i >= count($arrData)) {
                print  '</div>';
            } else {
                if ($i % 2 == 0) {
                    print '</div> <br>';
                }
            }
        }
    }

    echo '</div>';
    echo '</div>';
    echo '</section> ';
}

//Esta Parte es Nueva

function paint_template_search($message)
{
    $log = Log::getInstance();
    $log->add_log_general('error paint_template_search', 'products', 'response '.http_response_code()); //$text, $controller, $function
    $log->add_log_user('error paint_template_search', '', 'products', 'response '.http_response_code()); //$msg, $username = "", $controller, $function

    echo "<section> \n";
    echo "<div class='container'> \n";
    echo "<div class='row text-center pad-row'> \n";

    echo '<h2>'.$message."</h2> \n";
    echo "<br><br><br><br> \n";

    echo "</div> \n";
    echo "</div> \n";
    echo "</section> \n";
}
