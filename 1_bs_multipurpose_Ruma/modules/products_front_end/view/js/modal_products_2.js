$(document).ready(function () {
    $('.Titulo_Cuadro').click(function () {
        var id = this.getAttribute('id');
        //alert(id);

        $.get("modules/products/controller/controller_products.class.php?cod_cuadro=" + id, function (data, status) {
            var json = JSON.parse(data);
            var product = json.product;

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

           /* $("#product").dialog({
                width: 890, //<!-- -------------> ancho de la ventana -->
                height: 550, /*<!--  -------------> altura de la ventana -->
                //show: "scale", <!-- -----------> animación de la ventana al aparecer -->
                //hide: "scale", <!-- -----------> animación al cerrar la ventana -->
                resizable: "false", // <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
                //position: "down",<!--  ------> posicion de la ventana en la pantalla (left, top, right...) -->
                modal: "true", //<!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa (muy elegante) -->
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                    }
                },
                show: {
                    effect: "scale",
                    duration: 1000,
                    percent: 100
                },
                hide: {
                    effect: "scale",
                    duration: 1000,
                    percent: 0
                }

            });*/
        })
                .fail(function (xhr) {
                    $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php?view_error=true");
                });
    });
});
