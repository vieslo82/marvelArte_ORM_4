$(document).ready(function () {
    $('.product_name').click(function () {
        var id = this.getAttribute('id');
        //alert(id);

        $.get("modules/products_front_end/controller/controller_products_front_end.class.php?cod_cuadro=" + id, function (data, status) {

            var json = JSON.parse(data);
            var product = json.product;
            $('#results').html('');
            $('.pagination').html('');

            var img = document.getElementById('Imagen');
            img.innerHTML = '<img src="' + product.Imagen + '" class="img-product"> ';

            var nom_cuadro = document.getElementById('titulo');
            nom_cuadro.innerHTML = product.Titulo;
            var artista_cuadro = document.getElementById('artista');
            artista_cuadro.innerHTML = product.Artista;
            var precio_cuadro = document.getElementById('precio');
            precio_cuadro.innerHTML = "Precio: " + product.Precio + " €";
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
