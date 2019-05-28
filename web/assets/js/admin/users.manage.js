function banUser(userId) {
    var banId = document.getElementById("banId-" + userId);
    if (banId.innerHTML == "Заблокирован") {
        var action = "ban";
        var newStatus = 1;
    } else {
        action = "unban";
        newStatus = 0;
    }
    if (confirm("Вы уверены, что хотите " + action + " пользователя с ID " + userId + " ?")) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.status == 500 && this.readyState == 4) {
                window.location.replace("../error/error_500.php");
            } else if (this.status == 400 && this.readyState == 4) {
                window.location.replace("../error/error_400.php");
            } else if (this.status == 200 && this.readyState == 4) {
                if (newStatus == 0) {
                    banId.innerHTML = "Заблокирован";
                } else {
                    banId.innerHTML = "Активный";
                }
            }
        };
        xhttp.open("GET", "../../../controller/admin/users/ban_user_controller.php?uid="
            + userId + "&stat=" + newStatus, true);
        xhttp.send();
    }
}

function changeRole(userId) {
    var roleId = document.getElementById("roleId-" + userId);
    if (roleId.innerHTML == "Пользователь") {
        var action = "назначить";
        var newRole = 2;
    } else if (roleId.innerHTML == "Модератор") {
        action = "убрать";
        newRole = 1;
    } else if (roleId.innerHTML == "Админ") {
        alert("Нельзя изменить роль админа");
        throw "";
    }
    if (confirm("Вы уверены, что хотите " + action + " модератора с ID " + userId + " ?")) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.status == 500 && this.readyState == 4) {
                window.location.replace("../error/error_500.php");
            } else if (this.status == 400 && this.readyState == 4) {
                window.location.replace("../error/error_400.php");
            } else if (this.status == 200 && this.readyState == 4) {
                if (newRole == 2) {
                    roleId.innerHTML = "Модератор";
                } else {
                    roleId.innerHTML = "Пользователь";
                }
            }
        };
        xhttp.open("GET", "../../../controller/admin/users/moderator_user_controller.php?uid="
            + userId + "&nrole=" + newRole, true);
        xhttp.send();
    }
}