<?php
session_start();

$timezone = date_default_timezone_get("Europe/Mockow");

$con = mysqli_connect("mysql.zzz.com.ua","pe4enko01","Pe4enko123","pe4enko01");
if(mysqli_connect_errno()){
    echo "fail to connect" . mysqli_connect_errno();
};