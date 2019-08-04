<?php
	session_start();
	if (isset($_SESSION['mF2C_user']) && isset($_SESSION['mF2C_pass']) && isset($_SESSION['mF2C_time']))
	{
		$time = $_SESSION['mF2C_time'];
		if ((time() - $time) > 600)
		{
			//Session timeout (5 minutes)
			session_destroy();
			header("Location: main.html");
			die();
		}
		else
		{
			include 'functions.php'; //if you use this file outside this folder make sure to change the path of functions.php file
			$user = $_SESSION['mF2C_user'];
			$pass = $_SESSION['mF2C_pass'];
			$user_valid = Functions::validateCred($user, $pass);
			if ($user_valid)
			{
				//START YOUR CODE HERE
				
				//END YOU CODE HERE
			}
			else
			{
				//User is not authorized
				session_destroy();
				header("Location: main.html");
				die();
			}
		}
	}
	else
	{
		//Session variables are not set
		header("Location: main.html");
		die();
	}
?>