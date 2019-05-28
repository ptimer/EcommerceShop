function deleteSuperCat(superCatId) {
    if (confirm("Вы уверены, что хотите удалить суперкатегорию с ID " + superCatId + "? : " +
            "Это также удалит или выставит в null все, что входит в эту суперкатегорию (категории, товары, т.д)!")) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.status == 500 && this.readyState == 4) {
                window.location.replace("../error/error_500.php");
            } else if (this.status == 400 && this.readyState == 4) {
                window.location.replace("../error/error_400.php");
            } else if (this.status == 200 && this.readyState == 4) {
                $('#delId-' + superCatId).remove();
            }
        };
        xhttp.open("GET", "../../../controller/admin/supercategories/delete_supercategory_controller.php?scid=" + superCatId, true);
        xhttp.send();
    }
}

function deleteCat(catId) {
    if (confirm("Вы уверены, что хотите удалить категорию с ID " + catId + " ? : " +
            "Это также удалит или выставит в null все, что входит в эту категорию (категории, товары, т.д)!")) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.status == 500 && this.readyState == 4) {
                window.location.replace("../error/error_500.php");
            } else if (this.status == 400 && this.readyState == 4) {
                window.location.replace("../error/error_400.php");
            } else if (this.status == 200 && this.readyState == 4) {
                $('#delId-' + catId).remove();
            }
        };
        xhttp.open("GET", "../../../controller/admin/categories/delete_category_controller.php?cid=" + catId, true);
        xhttp.send();
    }
}

function deleteSubCat(subcatId) {
    if (confirm("Вы уверены, что хотите удалить подкатегорию с ID " + subcatId + " ? : " +
            "Это также удалит категории всех товаров, которые входят в эту подкатегорию !")) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.status == 500 && this.readyState == 4) {
                window.location.replace("../error/error_500.php");
            } else if (this.status == 400 && this.readyState == 4) {
                window.location.replace("../error/error_400.php");
            } else if (this.status == 200 && this.readyState == 4) {
                $('#delId-' + subcatId).remove();
            }
        };
        xhttp.open("GET", "../../../controller/admin/subcategories/delete_subcategory_controller.php?scid=" + subcatId, true);
        xhttp.send();
    }
}

function deleteSpec(specId) {
    if (confirm("Вы уверены, что хотите удалить характеристику с ID " + specId + " ? : " +
            "Это также удалит характеристику со всех товаров, которые содержат ее !")) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.status == 500 && this.readyState == 4) {
                window.location.replace("../error/error_500.php");
            } else if (this.status == 400 && this.readyState == 4) {
                window.location.replace("../error/error_400.php");
            } else if (this.status == 200 && this.readyState == 4) {
                $('#delId-' + specId).remove();
            }
        };
        xhttp.open("GET", "../../../controller/admin/subcategory_specs/delete_subcat_spec_controller.php?ssid=" + specId, true);
        xhttp.send();
    }
}

function deletePromo(promoId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.status == 500 && this.readyState == 4) {
            window.location.replace("../error/error_500.php");
        } else if (this.status == 400 && this.readyState == 4) {
            window.location.replace("../error/error_400.php");
        } else if (this.status == 200 && this.readyState == 4) {
            $('#delId-' + promoId).remove();
        }
    };
    xhttp.open("GET", "../../../controller/admin/products_promotions_reviews/delete_product_promotion_controller.php?prid="
        + promoId, true);
    xhttp.send();
}

function toggleVisibility(productId, currentVis) {
    if (confirm("Вы уверены, что хотите отключить видимость товара с ID " + productId + " ?")) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.status == 500 && this.readyState == 4) {
                window.location.replace("../error/error_500.php");
            } else if (this.status == 400 && this.readyState == 4) {
                window.location.replace("../error/error_400.php");
            } else if (this.status == 200 && this.readyState == 4) {
                var visibility = document.getElementById("togId-" + productId);
                if (visibility.innerHTML == "Yes") {
                    visibility.innerHTML = "No";
                } else {
                    visibility.innerHTML = "Yes";
                }
            }
        };
        xhttp.open("GET", "../../../controller/admin/products_promotions_reviews/visibility_product_controller.php?pid="
            + productId + "&vis=" + currentVis, true);
        xhttp.send();
    }
}