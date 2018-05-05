<?php
    $adminName = $_POST['login'];
    $pw = $_POST['pw'];

    if($adminName == "admin" && $pw = 123 ){
        echo '<script>location.replace("admin.php")</script>';
    };

?>