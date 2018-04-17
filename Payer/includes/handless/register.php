<?php

function formTextUsername($lol){
    $lol = strip_tags($lol);
    $lol = str_replace(" ","",$lol);
    return $lol;
};
function formTextSrting($lol){
    $lol = strip_tags($lol);
    $lol = str_replace(" ","",$lol);
    $lol = ucfirst(strtolower($lol));
    return $lol;
};
function formTextPassword($lol){
    $lol = strip_tags($lol);
    return $lol;
};


if(isset($_POST['registerButton'])){
    $username = formTextUsername($_POST['username']);
    $firstname = formTextSrting($_POST['firstname']);
    $lastname = formTextSrting($_POST['lastname']);
    $email = formTextSrting($_POST['email']);
    $email2 = formTextSrting($_POST['email2']);
    $password = formTextPassword($_POST['password']);
    $password2 = formTextPassword($_POST['password2']);

    $wasSuccesful = $account->register($username,$firstname,$lastname,$email,$email2,$password,$password2);

    if($wasSuccesful == true){
        $_SESSION['userLoggedIn'] = $username;
        echo '<script>window.location.href = "index.php";</script>';
    };
}
?>