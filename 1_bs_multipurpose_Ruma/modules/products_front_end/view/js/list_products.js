//Funciones para buscar producto en buscador

function validate_search(search_value) {
    if (search_value.length > 0) {
        var regexp = /^[a-zA-Z0-9 .,]*$/;
        return regexp.test(search_value);
    }
    return false;
}

function refresh() {
    $('.pagination').html = '';
    $('.pagination').val = '';
}

function search(keyword) {
    //changes the url to avoid creating another different function
    var urlbase = "modules/products_front_end/controller/controller_products_front_end.class.php";

    if (!keyword)
        url = urlbase + "?num_pages=true";
    else
        url = urlbase + "?num_pages=true&keyword=" + keyword;


    $.get(url, function(data, status) {
        var json = JSON.parse(data);
        var pages = json.pages;

        if (!keyword)
            url = urlbase;
        else
            url = urlbase + "?keyword=" + keyword;

          //  console.log(url);

        $("#results").load(url);

        if (pages !== 0) {
          //  refresh();

            $(".pagination").bootpag({
                total: pages,
                page: 1,
                maxVisible: 5,
                next: 'next',
                prev: 'prev'
            }).on("page", function(e, num) {
                e.preventDefault();
                if (!keyword)
                    $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php", {
                        'page_num': num
                    });
                else
                    $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php", {
                        'page_num': num,
                        'keyword': keyword
                    });
                reset();
            });
       } else {
            $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php?view_error=false"); //view_error=false
            $('.pagination').html('');

                  $('.prod').unbind('click');
                  $('.prod').bind('click', viewDetail);// al clickar llamamos funcion del Modal
            reset();
        }
        reset();

    }).fail(function(xhr) {
        $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php?view_error=true");
        $('.pagination').html('');
        reset();
    });
}


function search_product(keyword) {
    $.get("modules/products_front_end/controller/controller_products_front_end.class.php?nombre_cuadro=" + keyword, function(data, status) {
        var json = JSON.parse(data);
        var product = json.product_autocomplete;

        $('#results').html('');
        $('.pagination').html('');

        var img_product = document.getElementById('Imagen_Cuadro');
        img_product.innerHTML = '<img src="' + product[0].Imagen + '" class="img-product"> ';

        var nom_product = document.getElementById('Titulo_Cuadro');
        nom_product.innerHTML = product[0].Titulo;
        var artista_product = document.getElementById('Artista_Cuadro');
        artista_product.innerHTML = product[0].Artista;
        var price_product = document.getElementById('Precio_Cuadro');
        price_product.innerHTML = "Precio: " + product[0].Precio + " €";
        price_product.setAttribute("class", "special");

        $("#details_prod").show();
    }).fail(function(xhr) {
        $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php?view_error=false");
        $('.pagination').html('');
        reset();
    });
}

function count_product(keyword) {
    $.get("modules/products_front_end/controller/controller_products_front_end.class.php?total_products=" + keyword, function(data, status) {
        var json = JSON.parse(data);
        var num_products = json.num_products;
        //alert("num_products: " + num_products);

        if (num_products == 0) {
            $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php?view_error=false"); //view_error=false
            $('.pagination').html('');
            reset();
        }
        if (num_products == 1) {
            search_product(keyword);
        }
        if (num_products > 1) {
            search(keyword);
        }
    }).fail(function() {
        $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php?view_error=true"); //view_error=false
        $('.pagination').html('');
        reset();
    });
}

function reset() {
    //$('#img_product').html('');
    $('#nombre_cuadro').html('');
    $('#nombre_artista').html('');
    $('#precio_cuadro').html('');
    $('#precio_cuadro').removeClass("special");

    $('#keyword').val('');
}

//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_
$(document).ready(function() {


    //Parte Nueva
    if (getCookie("search")) {
        var keyword = getCookie("search");
        count_product(keyword);
        //alert("carrega pagina getCookie(search): " + getCookie("search"));
        //("#keyword").val(keyword) if we don't use refresh(), this way we could show the search param
        setCookie("search", "", 1);
    } else {
        search();
    }


    $("#search_prod").submit(function(e) {
        var keyword = document.getElementById('keyword').value;
        var v_keyword = validate_search(keyword);
        if (v_keyword)
            setCookie("search", keyword, 1);
        //lert("getCookie(search)1: " + getCookie("search"));
        location.reload(true);


        //si no ponemos la siguiente línea, el navegador nos redirecciona a index.php
        e.preventDefault(); //STOP default action
    });

    $('#Submit').click(function() {
        var keyword = document.getElementById('keyword').value;
        var v_keyword = validate_search(keyword);
        if (v_keyword)
            setCookie("search", keyword, 1);
        //alert("getCookie(search)2: " + getCookie("search"));
        location.reload(true);

    });

    $.get("modules/products_front_end/controller/controller_products_front_end.class.php?autocomplete=true", function(data, status) {
        var json = JSON.parse(data);
        var nom_productos = json.nom_productos;
        //alert(nom_productos[0].nombre);
        //console.log(nom_productos);

        var suggestions = new Array();
        for (var i = 0; i < nom_productos.length; i++) {
            suggestions.push(nom_productos[i].Titulo);
        }
        //alert(suggestions);
        //console.log(suggestions);

        $("#keyword").autocomplete({
            source: suggestions,
            minLength: 1,
            select: function(event, ui) {
                //alert(ui.item.label);

                var keyword = ui.item.label;
                count_product(keyword);
            }
        });
    }).fail(function(xhr) {
        $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php?view_error=false"); //view_error=false
        $('.pagination').html('');
        reset();
    });

});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1);
        if (c.indexOf(name) == 0)
            return c.substring(name.length, c.length);
    }
    return 0;
}

//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
