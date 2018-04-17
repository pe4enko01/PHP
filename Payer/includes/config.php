<?php
    session_start();

    $timezone = date_default_timezone_get("Europe/Mockow");

    $con = mysqli_connect("localhost","root","","slotify");
    if(mysqli_connect_errno()){
        echo "fail to connect" . mysqli_connect_errno();
    };