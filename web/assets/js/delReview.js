function delReview(reviewId) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        document.getElementById('rev-' + reviewId).innerHTML = "";

    };

    xhttp.open("GET", "../../controller/reviews/remove_review_controller.php?rev=" + reviewId, true);
    xhttp.send();
}