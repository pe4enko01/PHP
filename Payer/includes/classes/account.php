<?php
 class Account {
     private $con;
     private  $arrorArray ;

     public function __construct($con){
         $this->con = $con;
         $this->arrorArray = [];
     }

    public function login($un,$pw){
//        $pw = md5($pw);

        $query = mysqli_query($this->con,"SELECT * FROM users WHERE username = '$un' AND password = '$pw' ");
        if(mysqli_num_rows($query) == 1){
            return true;
        }else{
            array_push($this->arrorArray,Consta::$loginfale);
            return false;
        }
    }

     public function register($un,$fn,$ln,$em,$em2,$ps,$ps2){
         $this->validateUsername($un);
         $this->validateFirstname($fn);
         $this->validateLastname($ln);
         $this->validateEmails($em,$em2);
         $this->validatePasswords($ps,$ps2);

         if(empty($this->arrorArray)){
             return $this->insertUserDetails($un,$fn,$ln,$em,$ps);
         }else{
             return false;
         }
     }

     public function getError($error){
         if(!in_array($error,$this->arrorArray)){
             $error = "";
         }
          echo "<span class = 'errorMassage'>".$error."</span>";
     }

     private function insertUserDetails($un,$fn,$ln,$em,$ps){
         $encryptedPw = ($ps);
        $pofilepic = "assets/img/pro-file_img";
        $date = date("Y-m-d");
        $result = mysqli_query($this->con,"INSERT INTO users VALUES('','$un','$fn','$ln','$em','$encryptedPw','$date','$pofilepic')");
        return $result;

     }

     private function validateUsername($un){
        if(strlen($un)>25 || strlen($un)< 5){
            array_push($this->arrorArray,Consta::$usernameCharacters);

        };
        $checkquery = mysqli_query($this->con,"SELECT username FROM users WHERE username='$un'");
         if(mysqli_num_rows($checkquery)!= 0){
             array_push($this->arrorArray,Consta::$secUsername);

         };
     }
     private function validateFirstname($fn){
         if(strlen($fn)>25 || strlen($fn)< 2){
             array_push($this->arrorArray,Consta::$firstNameCharacters);
             return;
         };
     }
     private function validateLastname($ln){
         if(strlen($ln)>25 || strlen($ln)< 2){
             array_push($this->arrorArray,Consta::$lastNameCharacters);
             return;
         };
     }
     private function validateEmails($em1,$em2){
        if($em1 != $em2){
            array_push($this->arrorArray,Consta::$emailsDoNotMatch);
        };
        if(!filter_var($em1,FILTER_VALIDATE_EMAIL)){
            array_push($this->arrorArray,Consta::$emailInvalid);
        };
         $checkqueryem = mysqli_query($this->con,"SELECT email FROM users WHERE email='$em1'");
         if(mysqli_num_rows($checkqueryem)!= 0){
             array_push($this->arrorArray,Consta::$secEmail);

         };
     }
     private function validatePasswords($pw1, $pw2){
        if($pw1 != $pw2){
            array_push($this->arrorArray,Consta::$passwordsDoNoMatch);
        };
        if(preg_match('/[^A-Za-z0-9]/',$pw1)){
            array_push($this->arrorArray,Consta::$passwordNotAlphanumeric);
        }
     }
 }