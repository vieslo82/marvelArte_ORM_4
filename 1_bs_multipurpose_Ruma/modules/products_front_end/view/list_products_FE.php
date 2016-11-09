<script type="text/javascript" src="modules/products_front_end/view/js/jquery.bootpag.min.js"></script>
<script type="text/javascript" src="modules/products_front_end/view/js/list_products.js" ></script>

<section class="head-main-img">
    <div class="container">
        <div class="row text-center pad-row" >
            <div class="col-md-12">
              <h1>  LISTAR CUADRO </h1>
            </div>
        </div>
    </div>
</section>

<!-- Barra de Busqueda Productos-->
<center>
<form name="search_prod" id="search_prod" class="search_prod">
    <input type="text" value="" placeholder="Search Product ..." class="input_search" id="keyword" list="datalist">
    <!-- <div id="results_keyword"></div> -->
    <input name="Submit" id="Submit" class="button_search" type="button" value="Buscar" />

</form>
</center>
<!-- FIN Barra de Busqueda Productos-->

    <!--/.HEADING END-->
<div id="results"></div>

<center>
    <div class="pagination"></div>
</center>

<!-- modal window details_product -->
<section id="product">

    <div id="details_prod" hidden>

        <div id="details">
            <div id="Imagen_Cuadro" class="prodImg"></div>

            <div id="container">

                <h4> <strong><div id="Titulo_Cuadro"></div></strong> </h4>
                <br />
                <p>
                <div id="Artista_Cuadro"></div>
                </p>
                <h2> <strong><div id="Precio_Cuadro"></div></strong> </h5>

            </div>

        </div>

    </div>
</section>

<section >
    <div class="container" id="product">


        <div class="media">
            <div class="pull-left">
                <div id="Imagen" class="img_product"></div>
            </div>
            <div class="media-body">
                <div id="text-product">
                <h3 class="media-heading title-product" id="titulo"></h3>
                <h2  id="artista"></h2>
                <h3 class="media-heading title-product" id="precio"></h3>
                </div>

            </div>
        </div>



    </div>
</section>
