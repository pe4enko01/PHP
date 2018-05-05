<?php
$ins = $_POST['registerButton'];
if(isset($ins)) {
    $result = mysqli_query($con, "INSERT INTO taask VALUES('','$username','$email','$pic','$text')");

    $name = basename($_FILES["pic"]["name"]);
    $img = "images/";
    $errors = [];
    $expension = ["jpeg","ipg","png"];

    move_uploaded_file($_FILES['pic']['tmp_name'],$img.$name);
//    echo '<script>location.replace("index.php")</script>';

}

?>