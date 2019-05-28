function addFavourite(product_id) {

    //Create XMLHTTP request object (the keystone of AJAX)
    var xhttp = new XMLHttpRequest();

    //What happens when response is received
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById('favourite').innerHTML = "";
            document.getElementById('favourite').innerHTML = "<button class='btn btn-danger' onclick='removeFavourite(" + product_id + ")'><span class='glyphicon glyphicon-heart-empty'></span> Удалить с закладок</button>";
        }
    };

    //Where to send the request
    xhttp.open("GET", "../../../MagBuy/controller/favourites/add_favourites_controller.php?product_id=" + product_id, true);
    xhttp.send();
}

function removeFavourite(product_id) {

    //Create XMLHTTP request object (the keystone of AJAX)
    var xhttp = new XMLHttpRequest();

    //What happens when response is received
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById('favourite').innerHTML = "";
            document.getElementById('favourite').innerHTML = "<button class='btn btn-primary' onclick='addFavourite(" + product_id + ")'><span class='glyphicon glyphicon-heart'></span> Добавить в закладки</button>";
        }
    };

    //Where to send the request
    xhttp.open("GET", "../../../MagBuy/controller/favourites/remove_favourites_controller.php?product_id_remove=" + product_id, true);
    xhttp.send();
}

function removeFavouriteList(product_id) {

    //Create XMLHTTP request object (the keystone of AJAX)
    var xhttp = new XMLHttpRequest();

    //What happens when response is received
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

                if (this.responseText) {
                    document.getElementById('favouritesTitle').innerHTML = "Список закладок пуст";
                }

                document.getElementById('deleteItem' + product_id).innerHTML = "";
        }
    };

    //Where to send the request
    xhttp.open("GET", "../../../MagBuy/controller/favourites/remove_favourites_controller.php?product_id_remove=" + product_id, true);
    xhttp.send();
}