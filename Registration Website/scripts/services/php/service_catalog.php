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
			include '../../functions.php'; //if you use this file outside this folder make sure to change the path of functions.php file
			$user = $_SESSION['mF2C_user'];
			$pass = $_SESSION['mF2C_pass'];
			$user_valid = Functions::validateCred($user, $pass);
			if ($user_valid)
			{
				//START YOUR CODE HERE
				?>
				<!DOCTYPE HTML>
				<html>
				<head>
					<title>mF2C - Driving Through the Edge</title>
					<script src="../js/service_catalog.js"></script>
					<script type="text/javascript" src="../../jquery.js"></script>
					<link href="styles/sans.css" rel="stylesheet" type="text/css" />
					<link href="../../../styles/services.css" rel="stylesheet" type="text/css" media="all"/>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<link rel="icon" type="image/png" href="images/favicons/favicon-72x72.png" sizes="72x72">
					<link rel="icon" type="image/png" href="images/favicons/favicon-64x64.png" sizes="64x64">
					<link rel="icon" type="image/png" href="images/favicons/favicon-48x48.png" sizes="48x48">
					<link rel="icon" type="image/png" href="images/favicons/favicon-32x32.png" sizes="32x32">
					<link rel="icon" type="image/png" href="images/favicons/favicon-114x114.png" sizes="114x114">
					<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
					<meta name="keywords" content="mF2C, mF2C Registration, mF2C Project, mF2C - Driving Through the Edge, F2C" />
				</head>
				<body>
					<div class="content content_wide" id="catalog">
						<h1>Service Catalogue</h1>
					</div>
					<footer class="footer-distributed">
						<img src="../../../images/logomF2C.png"  alt="mF2C Project" width="60px"> 
						<img src="../../../images/logoEUH2020.png" alt="European Union's Horizon 2020" width="100px">
						<h5>This project has received funding from the European Union's Horizon 2020 research and innovation programme under grant agreement No 730929. The content of this site reflects only the mF2C Consortium view and not the official opinion of the European Commission. Responsibility for the use of the information therein lies entirely with the authors.</h5>
					</footer>	
				</body>
				</html>
				<?php
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