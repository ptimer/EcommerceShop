function addOneQuantityToCart(productId, productPrice) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.status == 500 && this.readyState == 4) {
            window.location.replace("../error/error_500.php");
        } else if (this.status == 404 && this.readyState == 4) {
            window.location.replace("../error/error_404.php");
        } else if (this.status == 200 && this.readyState == 4) {
            var items = document.getElementById("cartItems");
            items.innerHTML = parseInt(items.innerHTML) + 1;
            var price = document.getElementById("cartTotalPrice");
            price.innerHTML = (parseFloat(price.innerHTML) + productPrice).toFixed(2);
            var currentQuantity = document.getElementById("product-" + productId + "-quantity");
            currentQuantity.innerHTML = parseInt(currentQuantity.innerHTML) + 1;
            var currentTotalPrice = document.getElementById("product-" + productId + "-totalPrice");
            currentTotalPrice.innerHTML = (productPrice * currentQuantity.innerHTML).toFixed(2);
            var items2 = document.getElementById("cartItems2");
            items2.innerHTML = parseInt(items2.innerHTML) + 1;
            var price2 = document.getElementById("cartTotalPrice2");
            price2.innerHTML = (parseFloat(price2.innerHTML) + productPrice).toFixed(2);
        }
    };
    xhttp.open("GET", "../../controller/cart/add_to_cart_controller.php?pid=" + productId + "&pqty=1", true);
    xhttp.send();
}

function removeOneQuantityFromCart(productId, productPrice) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.status == 404 && this.readyState == 4) {
            window.location.replace("../error/error_404.php");
        } else if (this.status == 200 && this.readyState == 4) {
            var items = document.getElementById("cartItems");
            items.innerHTML = parseInt(items.innerHTML) - 1;
            var price = document.getElementById("cartTotalPrice");
            price.innerHTML = (parseFloat(price.innerHTML) - productPrice).toFixed(2);
            var currentQuantity = document.getElementById("product-" + productId + "-quantity");
            currentQuantity.innerHTML = parseInt(currentQuantity.innerHTML) - 1;
            var currentTotalPrice = document.getElementById("product-" + productId + "-totalPrice");
            currentTotalPrice.innerHTML = (productPrice * currentQuantity.innerHTML).toFixed(2);
            var items2 = document.getElementById("cartItems2");
            items2.innerHTML = parseInt(items2.innerHTML) - 1;
            var price2 = document.getElementById("cartTotalPrice2");
            price2.innerHTML = (parseFloat(price2.innerHTML) - productPrice).toFixed(2);
            if (currentQuantity.innerHTML == 0) {
                $('#product-' + productId).remove();
            }
        }
    };
    xhttp.open("GET", "../../controller/cart/remove_from_cart_controller.php?pid=" + productId + "&pqty=1", true);
    xhttp.send();
}