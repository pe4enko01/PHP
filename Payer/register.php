<?php
include("includes/handless/config.php");
include("includes/classes/account.php");
include("includes/classes/Consta.php");

$account = new Account($con);

include("includes/handless/register.php");
include("includes/handless/login.php");

?>
<html>
<head>
	<title>Welcome to Slotify!</title>
    <link rel="stylesheet" type="text/css" href = "assets/css/register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/JS/register.js"></script>
</head>
<body>
    <div id="all">
        <div id="logincontainer">
            <div id="inputContainer">
                <form id="loginForm" action="register.php" method="POST">
                    <h2>Login to your account</h2>
                    <p>
                        <?php $account->getError(Consta :: $loginfale) ?>
                        <label for="loginUsername">Username</label>
                        <input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. bartSimpson" required>
                    </p>
                    <p>
                        <label for="loginPassword">Password</label>
                        <input id="loginPassword" name="loginPassword" type="password" required>
                    </p>

                    <button type="submit" name="loginButton">LOG IN</button>
                    <div class="hasRegister">
                        <span id="hideLogin">Dont have an account yet? Sighup here.</span>
                    </div>
                </form>

                <form id="registerForm" action="register.php" method="POST">
                    <h2>Create your account</h2>
                    <p>
                        <?php $account->getError(Consta :: $usernameCharacters) ?>
                        <?php $account->getError(Consta :: $secUsername) ?>
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" placeholder="username" value="<?php echo $_POST['username']?>" required>
                    </p>
                    <p>
                        <?php $account->getError(Consta::$firstNameCharacters) ?>
                        <label for="firstname">First name</label>
                        <input id="firstname" name="firstname" type="text" placeholder="Akaki" value="<?php echo $_POST['firstname']?>" required>
                    </p>
                    <p>
                        <?php $account->getError(Consta::$lastNameCharacters) ?>
                        <label for="lastname">Lastname</label>
                        <input id="lastname" name="lastname" type="text" placeholder="Ov" value="<?php echo $_POST['lastname']?>" required>
                    </p>
                    <p>
                        <?php $account->getError(Consta :: $secEmail) ?>
                        <?php $account->getError(Consta::$emailInvalid) ?>
                        <label for="email">Email</label>
                        <input id="email" name="email" type="text" placeholder="email" value="<?php echo $_POST['email']?>"  required>
                    </p>
                    <p>
                        <?php $account->getError(Consta::$emailsDoNotMatch) ?>
                        <label for="email2">Email2</label>
                        <input id="email2" name="email2" type="text" placeholder="email2" value="<?php echo $_POST['email2']?>"  required>
                    </p>


                    <p>

                        <?php $account->getError(Consta::$passwordNotAlphanumeric) ?>
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" required>
                    </p>
                    <p>
                        <?php $account->getError(Consta::$passwordsDoNoMatch) ?>
                        <?php $account->getError(Consta::$passwordNotAlphanumeric) ?>
                        <label for="password2">Password2</label>
                        <input id="password2" name="password2" type="password2" required>
                    </p>

                    <button type="submit" name="registerButton">SIGN UP</button>
                    <div class="hasRegister">
                        <span id="hideRegister">Already have an account?Login in here</span>
                    </div>
                </form>
            </div>
            <div id="loginText">
                <h1>Get great music, right now</h1>
                <h2>Listen to loads of songs for free</h2>
                <ul>
                    <li>Discover music you'll fall in love with</li>
                    <li>Create your own playlists</li>
                    <li>Follow artists to keep up to date</li>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>