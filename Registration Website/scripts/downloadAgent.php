<?php
	session_start();
	if (isset($_SESSION['mF2C_user']) && isset($_SESSION['mF2C_pass']) && isset($_SESSION['mF2C_time']))
	{
		$time = $_SESSION['mF2C_time'];
		if ((time() - $time) > 600)
		{
			//Session timeout (5 minutes)
			session_destroy();
			header("Location: ../main.html");
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
				$actuator = $_GET['actuator'];
				$sensor = $_GET['sensor'];
				$agent = $_GET['agent'];
				$file = "";
				if ($agent == 3)
					$file = "https://raw.githubusercontent.com/mF2C/mF2C/master/microagent/docker-compose.yml";
				else
					$file = "https://raw.githubusercontent.com/mF2C/mF2C/master/agent/docker-compose.yml";
				header("Content-type: text/script");
				header("Content-Disposition: attachment; filename=mf2c-deployment.sh");
				$docker_compose_file = file_get_contents($file);
				$filearray = explode("\n", $docker_compose_file);
				while (list($var, $val) = each($filearray))
				{
					++$var;
					print "$val \n";
					if($val == "       - 46070") //place env var after the expose tag for the categorization module
					{
						print "    environment: \n";
						print "      - targetDeviceActuator=$actuator \n";
						print "      - targetDeviceSensor=$sensor \n";
						print "      - agentType=$agent \n";
					}
				}
				//END YOU CODE HERE
			}
			else
			{
				//User is not authorized
				session_destroy();
				header("Location: ../main.html");
				die();
			}
		}
	}
	else
	{
		//Session variables are not set
		header("Location: ../main.html");
		die();
	}
?>