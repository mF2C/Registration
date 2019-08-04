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
					<script src="../js/service_register.js"></script>
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
					<meta name="keywords" content="mF2C, mF2C Registration, mF2C Project, mF2C - Driving Through the Edge, F2C" />
				</head>
				<body>
					<div class="content content_thick">
						<h1>Service Registration</h1>
						<span class="line"> </span>
						<h3>Fill the required information for submitting your service into the mF2C</h3>
						
						<h5>Name </h5>
						<input type="text" id="name" placeholder="Name of the service (ex: Hello World)" onBlur="" />

						<h5>Description </h5>
						<input type="text" id="description" placeholder="Short description (ex: This is a hello world test)" onBlur="" />

						<h5>Name of the executable</h5>
						<input type="text" id="exec" placeholder="Name of the executable (ex: hello-world)" onBlur="" />

						<h5>Type of executable</h5>
						<select type="text" id="exec_type" onchange="execTypeFunction()">
							<option type="text" value="docker">Docker</option>
							<option type="text" value="compss">COMPSs</option>
							<option type="text" value="docker-compose">docker-compose</option>
						</select>

						<h5>Ports (if required)</h5>
						<input type="text" id="exec_ports" disabled placeholder="Required ports for the executable (ex: 8080, 8081)" onBlur="" />
						
						<h5>CPU</h5>
						<select type="text" id="cpu">
							<option type="text" value="high">High</option>
							<option type="text" value="medium">Medium</option>
							<option type="text" value="low">Low</option>
						</select>

						<h5>Memory</h5>
						<select type="text" id="memory">
							<option value="high">High</option>
							<option value="medium">Medium</option>
							<option value="low">Low</option>
						</select>
						
						<h5>Storage</h5>
						<select type="text" id="storage">
							<option value="high">High</option>
							<option value="medium">Medium</option>
							<option value="low">Low</option>
						</select>

						<h5><input type="checkbox" id="inclinometer"> Inclinometer sensor</h5>
						<h5><input type="checkbox" id="temperature"> Temperature sensor</h5>
						<h5><input type="checkbox" id="jammer"> Jammer sensor</h5>
						<h5><input type="checkbox" id="location"> Location (GPS sensor)</h5>
						<h5><input type="checkbox" id="battery"> Battery level sensor</h5>
						<h5><input type="checkbox" id="door"> Door sensor</h5>
						<h5><input type="checkbox" id="pump"> Pump sensor</h5>
						<h5><input type="checkbox" id="accelerometer"> Accelerometer sensor</h5>
						<h5><input type="checkbox" id="humidity"> Humidity sensor</h5>
						<h5><input type="checkbox" id="pressure"> Air pressure sensor</h5>
						<h5><input type="checkbox" id="ir_motion"> IR motion sensor</h5>
						
						
						<button class="button button-submit" onClick="registerService()">Register</button>
						<button class="button button-cancel" onClick="registerServiceCancel()">Cancel</button>         

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