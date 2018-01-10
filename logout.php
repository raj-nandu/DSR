<?php
  // If the user is logged in, delete the session vars to log them out
	  session_start();
	  if (isset($_SESSION['auth'])) {
	  	session_destroy();
	  	session_start();
	  	$_SESSION['auth'] = false;
		header('location: login.php');
	}
?>