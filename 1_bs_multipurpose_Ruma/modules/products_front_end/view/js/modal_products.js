//we do this so that  details_prod don't appear
$("#details_prod").hide();

function viewDetail(e) { // la e es por que es objetio tipo evento
    var id = this.getAttribute('id');
    //alert(id);

    $.get("modules/products_front_end/controller/controller_products_front_end.class.php?cod_cuadro=" + id, function(data, status) {
            var json = JSON.parse(data);
            var product = json.product;

            $("#Imagen_Cuadro").html('<img src="' + product.Imagen + '" height="75" width="75"> ');
            $("#Titulo_Cuadro").html(product.Titulo);
            $("#Artista_Cuadro").html("<strong>Description: <br/></strong>" + product.Artista);
            $("#Precio_Cuadro").html("Price: " + product.Precio + " €");

            //we do this so that  details_prod  appear
            $("#details_prod").show();


            $("#product").dialog({
                width: 850, //<!-- ------------- ancho de la ventana -->
                height: 500, //<!--  ------------- altura de la ventana -->
                //show: "scale", <!-- ----------- animación de la ventana al aparecer -->
                //hide: "scale", <!-- ----------- animación al cerrar la ventana -->
                resizable: "false", //<!-- ------ fija o redimensionable si ponemos este valor a "true" -->
                //position: "down",<!--  ------ posicion de la ventana en la pantalla (left, top, right...) -->
                modal: "true", //<!-- ------------ si esta en true bloquea el contenido de la web mientras la ventana esta activa (muy elegante) -->
                buttons: {
                    Ok: function() {
                        $(this).dialog("close");
                    }
                },
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                },
                create: function(event, ui) {
                    var widget = $(this).dialog("widget");
                    $(".ui-dialog-titlebar-close", widget).text('X');
                }
            });
        })
        .fail(function(xhr) {
            //if  we already have an error 404
            if (xhr.status === 404) {
                $("#results").load("modules/products_front_end/controller/controller_product_front_end.class.php?view_error=false");
            } else {
                $("#results").load("modules/products_front_end/controller/controller_product_front_end.class.php?view_error=true");
            }
        });
}
