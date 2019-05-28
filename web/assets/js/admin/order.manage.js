function changeStatus(orderId) {
    var xhttp = new XMLHttpRequest();
    var newStatus = document.getElementById("newStatus").value;

    xhttp.onreadystatechange = function () {
        if (this.status == 400 && this.readyState == 4) {
            window.location.replace("../error/error_400.php");
        } else if (this.status == 200 && this.readyState == 4) {
            var status = document.getElementById("status");
            status.innerHTML = newStatus;
        }
    };
    xhttp.open("GET", "../../../controller/admin/orders/status_order_controller.php?oid=" + orderId + "&ns=" + newStatus, true);
    xhttp.send();
}