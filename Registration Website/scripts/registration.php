<?php
	include 'functions.php';
	if (isset($_POST['uName']) && isset($_POST['uEmail']) && isset($_POST['uPass']) && isset($_POST['uPass2']))
	{
		$user = strtolower(trim($_POST['uName']));
		$mail = strtolower(trim($_POST['uEmail']));
		$pass = $_POST['uPass'];
		$pass2 = $_POST['uPass2'];
		$code = 0;
		while ($code == 0)
		{
			//Start inputs validations
			if (strlen($user) < 8)
			{
				$code = 1;
				break;
			}
			if (strlen($pass) < 8)
			{
				$code = 2;
				break;
			}
			if ($pass != $pass2)
			{
				$code = 3;
				break;
			}
			$user_valid = Functions::userExists($user);
			if ($user_valid)
			{
				//user already exists in the system
				$code = 4;
				break;
			}
			$mail = Functions::sanitizeEmail($mail);
			if (strcmp($mail, "error") == 0)
			{
				$code = 5;
				break;
			}
			$mail_valid = Functions::mailExists($mail);
			if ($mail_valid)
			{
				//email already exists in the system
				$code = 6;
				break;
			}
			//End Input validations
			$register = Functions::register($user, $mail, $pass, $pass2);
			$code = $register;
			break;
		}
		echo $code;
	}
	else
	{
		Functions::redirect('../main.html');
	}
?>