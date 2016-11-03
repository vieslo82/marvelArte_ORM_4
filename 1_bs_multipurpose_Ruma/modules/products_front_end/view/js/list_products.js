$(document).ready(function() {
    $.get("modules/products_front_end/controller/controller_products_front_end.class.php?num_pages=true", function(data, status) {
        var json = JSON.parse(data);
        var pages = json.pages;

        $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php", function(response, status, xhr) {
            if (status == "error") {
                // alert(msg + xhr.status + " " + xhr.statusText);
                console.log(msg + xhr.status + " " + xhr.statusText);
            } else {
                $('.prod').unbind('click');//borrar evento
                $('.prod').bind('click', viewDetail);// al clickar llamamos funcion del Modal
            }
        }); //load initial records

        // init bootpag
        $(".pagination").bootpag({
            total: pages,
            page: 1,
            maxVisible: 3,
            next: 'next',
            prev: 'prev'
        }).on("page", function(e, num) {
            //alert(num);
            e.preventDefault();
            //$("#results").prepend('<div class="loading-indication"><img src="modules/services/view/img/ajax-loader.gif" /> Loading...</div>');
            $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php", {
                'page_num': num
            }, function(response, status, xhr) {
              if (status == "error") {
                  // alert(msg + xhr.status + " " + xhr.statusText);
                  console.log(msg + xhr.status + " " + xhr.statusText);
              }else {
                  $('.prod').unbind('click');
                  $('.prod').bind('click', viewDetail);// al clickar llamamos funcion del Modal
              }
            });

            // ... after content load
            /*$(this).bootpag({
             total: pages,
             maxVisible: 7
             });*/
        });

    }).fail(function(xhr) {
        //console.log(xhr.status);
        //die();
        //var json = JSON.parse(xhr.responseText);
        //alert(json.error);

        //if (xhr.responseText !== undefined && xhr.responseText !== null) {
        //var json = JSON.parse(xhr.responseText);
        //if (json.error !== undefined && json.error !== null) {
        //$("#results").text(json.error);

        //if  we already have an error 404
        if (xhr.status === 404) {
            $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php?view_error=false");
        } else {
            $("#results").load("modules/products_front_end/controller/controller_products_front_end.class.php?view_error=true");
        }

        //}
        //}
    });
});
