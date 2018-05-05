<?php
include("includes/conect.php");
include("includes/save_data.php");
include("includes/add_task.php");
include("includes/adminlogin.php");
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>todo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="first-block">
    <p id="go-admin">Войти</p>
    <div id="admin-block">
        <form id="admin" action="index.php" method="POST">
            <p id="exit">Выйти</p>
            <p class="login-p">
                <label for="login">Логин</label>
                <input id="login" name="login" type="text" placeholder="login" value="" required>
            </p>
            <p class="pw-p">
                <label for="pw">Пароль</label>
                <input id="pw" name="pw" type="text" placeholder="username" value="" required>
            </p>
            <button type="submit" name="adminButton">Войти</button>
        </form>
    </div>
    <div class="container">
        <div class="title-block">
            <h1 id="title">Задачи</h1>
        </div>

        <!--            // Форма-->

        <div class="add-task">
            <form id="registerForm" action="index.php" method="POST" enctype="multipart/form-data">
                <p class="form-input">
                    <label for="username">Имя</label>
                    <input id="username" name="username" type="text" placeholder="username" value="" required>
                </p>
                <p class="form-input">
                    <label for="e-mail">E-mail</label>
                    <input id="e-mail" name="email" type="text" placeholder="username" value="" required>
                </p>
                <p class="form-input">
                    <label for="pic">Картинка</label>
                    <input id="pic" name="pic" type="file" placeholder="username" value="" required>
                </p>
                <p>
                    <label for="text">Задача</label>
                    <input id="text" name="text" type="text" placeholder="username" value="" required>

                </p>
                <button type="submit" name="registerButton">Добавить</button>
            </form>
            <a href="index.php">Сортировать по статусу</a>
            <a href="index_email.php">Сортировать по емейлу </a>
            <a href="index_name.php">Сортировать по имени</a>
        </div>


        <!--            // Задачи-->

        <div class="task-container">
            <?php
            $img = "images/";
            $num = 2;
            $page = $_GET['page'];
            $result00 = mysqli_query($con, "SELECT COUNT(*) FROM taask");
            $temp = mysqli_fetch_array($result00);
            $posts = $temp[0];
            $total = (($posts - 1) / $num) + 1;
            $total = intval($total);
            $page = intval($page);
            if (empty($page) or $page < 0) $page = 1;
            if ($page > $total) $page = $total;
            $start = $page * $num - $num;

            $query = mysqli_query($con, "SELECT * FROM taask ORDER BY id DESC   LIMIT $start, $num");

            while ($row = mysqli_fetch_array($query)) {
                echo                         " 
                                             <div class='task'>
                                                <div class='left-side-of-task'>
                                                        <p>" . $row['username'] . " </p>
                                                        <p>" . $row['email'] . "</p>
                                                        <img id='pic' src=".$img .$row['pic'].">
                                                </div>
                                                <div class='rigt-side-of-task'>
                                                        <p class='text-of-task'>" . $row['text'] . "</p>
                                                </div>
                                              </div> 
                                              ";
            };

            // Проверяем нужны ли стрелки назад
            if ($page != 1) $pervpage = '<a href=index.php?page=1>Первая</a> | <a href=index.php?page=' . ($page - 1) . '>Предыдущая</a> | ';
            // Проверяем нужны ли стрелки вперед
            if ($page != $total) $nextpage = ' | <a href=index.php?page=' . ($page + 1) . '>Следующая</a> | <a href=index.php?page=' . $total . '>Последняя</a>';

            // Находим две ближайшие станицы с обоих краев, если они есть
            if ($page - 5 > 0) $page5left = ' <a href=index.php?page=' . ($page - 5) . '>' . ($page - 5) . '</a> | ';
            if ($page - 4 > 0) $page4left = ' <a href=index.php?page=' . ($page - 4) . '>' . ($page - 4) . '</a> | ';
            if ($page - 3 > 0) $page3left = ' <a href=index.php?page=' . ($page - 3) . '>' . ($page - 3) . '</a> | ';
            if ($page - 2 > 0) $page2left = ' <a href=index.php?page=' . ($page - 2) . '>' . ($page - 2) . '</a> | ';
            if ($page - 1 > 0) $page1left = '<a href=index.php?page=' . ($page - 1) . '>' . ($page - 1) . '</a> | ';

            if ($page + 5 <= $total) $page5right = ' | <a href=index.php?page=' . ($page + 5) . '>' . ($page + 5) . '</a>';
            if ($page + 4 <= $total) $page4right = ' | <a href=index.php?page=' . ($page + 4) . '>' . ($page + 4) . '</a>';
            if ($page + 3 <= $total) $page3right = ' | <a href=index.php?page=' . ($page + 3) . '>' . ($page + 3) . '</a>';
            if ($page + 2 <= $total) $page2right = ' | <a href=index.php?page=' . ($page + 2) . '>' . ($page + 2) . '</a>';
            if ($page + 1 <= $total) $page1right = ' | <a href=index.php?page=' . ($page + 1) . '>' . ($page + 1) . '</a>';

            // Вывод меню если страниц больше одной

            if ($total > 1) {
                Error_Reporting(E_ALL & ~E_NOTICE);
                echo "<div class=\"pstrnav\">";
                echo $pervpage . $page5left . $page4left . $page3left . $page2left . $page1left . '<b>' . $page . '</b>' . $page1right . $page2right . $page3right . $page4right . $page5right . $nextpage;
                echo "</div>";
            }

            ?>
        </div>
    </div>
</div>

<script>
    var ad = document.getElementById("go-admin");
    var adminForm = document.getElementById("admin-block");
    var exit = document.getElementById("exit");
    ad.onclick = function () {
        adminForm.style.display = "flex";
    };
    exit.onclick = function () {
        adminForm.style.display = "none";
    };
</script>
</body>
</html>