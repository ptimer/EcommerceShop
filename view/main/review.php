<?php
//Автолоадер
require_once "../../utility/autoloader.php";
//Проверяем на сессию
require_once "../../utility/no_session_main.php";
//Стили, скрипты
require_once "../elements/headers.php";
?>

    <link rel="stylesheet" href="../../web/assets/css/addReview.css">

    <title>lGG'sP | Добавить отзыв></title>
    </head>

<?php
//Хедер
require_once "../elements/header.php";
//Навигация
require_once "../elements/navigation.php";
?>

    <!-- Добавление нового отзыв -->
    <div class="container">
        <form action="../../controller/reviews/add_review_controller.php?pid=<?= $_GET['pid'] ?>" method="post">

            <div id='uppderDiv'></div>
            <label>Оценить</label>
            <div id='lowerDiv'></div>
            <label class="radio-inline"><input type="radio" name="rating" value="1" required>
                <img class="starRating" src="../../web/assets/images/star1.png"></label>
            <label class="radio-inline"><input type="radio" name="rating" value="2" required>
                <img class="starRating" src="../../web/assets/images/star2.png"></label>
            <label class="radio-inline"><input type="radio" name="rating" value="3" required checked>
                <img class="starRating" src="../../web/assets/images/star3.png"></label>
            <label class="radio-inline"><input type="radio" name="rating" value="4" required>
                <img class="starRating" src="../../web/assets/images/star4.png"></label>
            <label class="radio-inline"><input type="radio" name="rating" value="5" required>
                <img class="starRating" src="../../web/assets/images/star5.png"></label>
            <div class="clearfix"></div>

            <label id='labelTitle' for="title">Заголовок</label>
            <input class="form-control" type="text" name="title" placeholder="Введите заголовок" id="title"
                   pattern=".{3,500}" required title="Заголовок может быть от 3 до 500 символов">

            <label id='labelTextArea' for="reviewArea">Отзыв</label>
            <textarea class="form-control" rows="5" name="review" id="reviewArea"
                      maxlength="3000" minlength="3" required></textarea><br/>

            <button id='addReviewButton' type="submit" class="btn btn-primary btn-warning">
                <span class="glyphicon glyphicon-tag"></span> Опубликовать
            </button>

        </form>
    </div>

<?php
//Футер
require_once "../elements/footer.php";
?>