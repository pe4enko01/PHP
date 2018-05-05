    <?php
        if(isset($_POST['registerButton'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $pic = $_FILES["pic"]["name"];
            $text = $_POST['text'];
        }

    ?>