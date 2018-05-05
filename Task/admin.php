<?php
include("includes/adminlogin.php");
include("includes/conect.php");
include("includes/save_data.php");


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

            ini_set('display_errors','Off');
            while ($row = mysqli_fetch_array($query)) {

                echo                        " 
                                             <div class='task'>
                                                <div class='left-side-of-task'>
                                                        <p>" . $row['username'] . " </p>
                                                        <p>" . $row['email'] . "</p>
                                                        <img id='pic' src=" . $img . $row['pic'] . ">
                                                </div>
                                                <div class='rigt-side-of-task'>
                                                
                                                       <form action='admin.php' method='POST'>
                                                       <p class='form-input-2'>
                                                         <label for='adminText'></label>
                                                         <input id='adminText' name='adminText' type='text' value='" . $row['text'] . "'>
                                                       </p>
                                                         <input id='' name='adminText-2' type='hidden' value='" . $row['id'] . "'>
                                                       
                                                       <button type='submit' name='adminCorect' >Редактировать</button>
                                                       </form>
                                                       
                                                        <form action='admin.php' method='POST'>
                                                        <input id='' name='adminText-3' type='hidden' value='" . $row['id'] . "'>
                                                            <button type='submit' name='complite' >Выполнено</button>
                                                        </form>
                                                </div>
                                              </div> 
                                              ";

            };
            include("includes/admin_corection.php");
            // Проверяем нужны ли стрелки назад
            if ($page != 1) $pervpage = '<a href=admin.php?page=1>Первая</a> | <a href=admin.php?page=' . ($page - 1) . '>Предыдущая</a> | ';
            // Проверяем нужны ли стрелки вперед
            if ($page != $total) $nextpage = ' | <a href=admin.php?page=' . ($page + 1) . '>Следующая</a> | <a href=admin.php?page=' . $total . '>Последняя</a>';

            // Находим две ближайшие станицы с обоих краев, если они есть
            if ($page - 5 > 0) $page5left = ' <a href=admin.php?page=' . ($page - 5) . '>' . ($page - 5) . '</a> | ';
            if ($page - 4 > 0) $page4left = ' <a href=admin.php?page=' . ($page - 4) . '>' . ($page - 4) . '</a> | ';
            if ($page - 3 > 0) $page3left = ' <a href=admin.php?page=' . ($page - 3) . '>' . ($page - 3) . '</a> | ';
            if ($page - 2 > 0) $page2left = ' <a href=admin.php?page=' . ($page - 2) . '>' . ($page - 2) . '</a> | ';
            if ($page - 1 > 0) $page1left = '<a href=admin.php?page=' . ($page - 1) . '>' . ($page - 1) . '</a> | ';

            if ($page + 5 <= $total) $page5right = ' | <a href=admin.php?page=' . ($page + 5) . '>' . ($page + 5) . '</a>';
            if ($page + 4 <= $total) $page4right = ' | <a href=admin.php?page=' . ($page + 4) . '>' . ($page + 4) . '</a>';
            if ($page + 3 <= $total) $page3right = ' | <a href=admin.php?page=' . ($page + 3) . '>' . ($page + 3) . '</a>';
            if ($page + 2 <= $total) $page2right = ' | <a href=admin.php?page=' . ($page + 2) . '>' . ($page + 2) . '</a>';
            if ($page + 1 <= $total) $page1right = ' | <a href=admin.php?page=' . ($page + 1) . '>' . ($page + 1) . '</a>';

            // Вывод меню если страниц больше одной

            if ($total > 1) {
                Error_Reporting(E_ALL & ~E_NOTICE);
                echo "<div class=\"pstrnav\">";
                echo $pervpage . $page5left . $page4left . $page3left . $page2left . $page1left . '<b>' . $page . '</b>' . $page1right . $page2right . $page3right . $page4right . $page5right . $nextpage;
                echo "</div>";
            }
//            echo '<script>location.replace("admin.php?page='.$page.'")</script>';
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