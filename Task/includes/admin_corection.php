<?php

if(isset($_POST['adminCorect'])) {
    $adminCorection = $_POST['adminText'];
    $ass = $_POST['adminText-2'];
    mysqli_query($con,"UPDATE taask SET text = '$adminCorection'  WHERE id = '$ass' ");
    echo '<script>location.replace("admin.php?page='.$page.'")</script>';

}

if(isset($_POST['complite'])){
    $ass = $_POST['adminText-3'];
    mysqli_query($con,"DELETE FROM `taask` WHERE `taask`.`id` = '$ass' ");
    echo '<script>location.replace("admin.php")</script>';
}
?>


