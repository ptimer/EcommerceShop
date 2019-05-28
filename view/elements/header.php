</head>
<body>
<div class="top_bar">
    <div class="container">
        <div class="header_top">

            <!-- Пользовательский контроль -->
            <div class="top_right">
                <ul>
                    <?php
                    // Если есть сессия авторизации, то соответствующее условие
                    if (isset($_SESSION['loggedUser'])) {
                        echo '<li><a href="../user/edit.php">Настройки профиля</a></li>';
                        echo '<li><a href="../../utility/log_out.php">Выйти</a></li>';
                    } else {
                        echo '<li><a href="../user/register.php">Зарегистрироваться</a></li>';
                        echo '<li><a href="../user/login.php">Войти</a></li>';
                        echo '<li><a href="../main/about.php">О магазине</a></li>';
                        echo '<li><a href="../main/payment.php">Оплата и доставка</a></li>';
                        echo '<li><a href="../main/contacts.php">Контакты</a></li>';
                    }
                    ?>
                    <?php 
                        // Проверяем уровень доступа пользователя
                        if(isset($_SESSION['role']) && ($_SESSION['role'] == 3 || $_SESSION['role'] == 2)) { 
                    ?>
                        <li><a href="../admin/admin_panel.php">Админ панель</a></li>
                    
                    <?php } ?>
                </ul>
            </div>
            <?php
            // Берем текущий адрес view/main/index.php
            $url = $_SERVER['PHP_SELF'];
            // Получаем main
            $urlCheck = array_slice(explode('/', $url), -2)[0];
            // Получаем view
            $urlCheck2 = array_slice(explode('/', $url), -3)[0];
            
            // Если мы не зашли админ панель, то отображаем поиск. 
            if ($urlCheck != "admin" && $urlCheck2 != "admin") {
                ?>
                <!-- Поиск -->
                <div class="top_left">
                    <form action="../main/search.php" method="get" autocomplete="off">
                        <input name="search" id="search" class="form-control" type="text"
                               placeholder="Найти"
                               onkeyup="searchSuggest()" required>
                        <div id='result'></div>
                        <input type="submit" id="search-submit">
                    </form>
                </div>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>