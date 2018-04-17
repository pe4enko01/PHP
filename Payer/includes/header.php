<?php
include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");

//session_destroy(); LOGOUT

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
}
else {
	header("Location: register.php");
}

?>

<html>
<head>
	<title>Welcome to Slotify!</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="assets/JS/script.js"></script>

</head>

<body>

    <script>
//        var audioElement = new Audio();
//        audioElement.setTrack("assets/music/bensound-acousticbreeze.mp3");
//        audioElement.audio.play();
    </script>
	<div id="mainContainer">

		<div id="topContainer">

			<?php include("includes/navBarContainer.php"); ?>

			<div id="mainViewContainer">

				<div id="mainContent">