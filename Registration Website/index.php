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
		include 'scripts/functions.php';
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
				<script src="scripts/functions.js"></script>
				<script src="scripts/services/js/service_register.js"></script>
				<script src="scripts/services/js/service_catalog.js"></script>
				<script type="text/javascript" src="scripts/jquery.js"></script>
					<link href="styles/sans.css" rel="stylesheet" type="text/css" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link href="styles/registration.css" rel="stylesheet" type="text/css" media="all"/>
				<link rel="icon" type="image/png" href="images/favicons/favicon-72x72.png" sizes="72x72">
				<link rel="icon" type="image/png" href="images/favicons/favicon-64x64.png" sizes="64x64">
				<link rel="icon" type="image/png" href="images/favicons/favicon-48x48.png" sizes="48x48">
				<link rel="icon" type="image/png" href="images/favicons/favicon-32x32.png" sizes="32x32">
				<link rel="icon" type="image/png" href="images/favicons/favicon-114x114.png" sizes="114x114">
			</head>
			<body>
				<div class="content">
					<div class="header">
						<h1>mF2C</h1>
						<h2>Towards an Open, Secure, Decentralized and Coordinated Fog-to-Cloud Management Ecosystem</h2>
					</div>
					<div class="body">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><a class="link" id="formAgent" onClick="showForm(1)"><img src="images/cloud.png" alt="Cloud"><br><h9>Cloud<br>Agent</h9></a></td>
								<td><a class="link" id="formAgent" onClick="showForm(2)"><img src="images/fog.png" alt="Fog"><br><h9>Fog<br>Agent</h9></a></td>
								<td><a class="link" id="formAgent" onClick="showForm(3)"><img src="images/iot.png" alt="IoT"><br><h9>Micro<br>Agent</h9></a></td>
							</tr>
						</table>
						<div id="modalForm" class="modal">
							<div class="modal-content">
								<span class="close">&times;</span>
								<p id="mTitle"></p><br>
								<table width="95%" align="center" border="0" cellpadding="0" cellspacing="0">
									<tr><td colspan="2" align="left">Select the actuators available at the target device:</td></tr>
									<tr align="left">
										<td width="10%"><input type="radio" name="target_a" id="none_a" value="N" onChange="chboxToggleActuator()"></td>
										<td>None</td>
									</tr>
									<tr align="left">
										<td width="10%"><input type="radio" name="target_a" id="actu" value="A" checked onChange="chboxToggleActuator()"></td>
										<td>Actuator:</td>
									</tr>
									<tr align="left">
										<td width="10%"></td>
										<td width="90%"><input type="checkbox" name="actuator[]" id="checkedB[]" value="A"> Ambulance</td>
									</tr>
									<tr align="left">
										<td width="10%"></td>
										<td width="90%"><input type="checkbox" name="actuator[]" id="checkedB[]" value="F"> Firetruck</td>
									</tr>
									<tr align="left">
										<td width="10%"></td>
										<td width="90%"><input type="checkbox" name="actuator[]" id="checkedB[]" value="S"> Sirene</td>
									</tr>
									<tr align="left">
										<td width="10%"></td>
										<td width="90%"><input type="checkbox" name="actuator[]" id="checkedB[]" value="T"> Traffic light</td>
									</tr>
								</table>
								<table width="95%" align="center" border="0" cellpadding="0" cellspacing="0">
									<tr><td colspan="2" align="left">Select the sensors available at the target device:</td></tr>
									<tr align="left">
										<td width="10%"><input type="radio" name="target_s" id="none_s" value="N" onChange="chboxToggleSensor()"></td>
										<td>None</td>
									</tr>
									<tr align="left">
										<td width="10%"><input type="radio" name="target_s" id="sens" value="A" checked onChange="chboxToggleSensor()"></td>
										<td>Sensors:</td>
									</tr>
									<tr align="left">
										<td width="10%"></td>
										<td width="90%"><input type="checkbox" name="sensor[]" id="checkedB[]" value="L"> Location</td>
									</tr>
									<tr align="left">
										<td width="10%"></td>
										<td width="90%"><input type="checkbox" name="sensor[]" id="checkedB[]" value="J"> Jammer detector</td>
									</tr>
									<tr align="left">
										<td width="10%"></td>
										<td width="90%"><input type="checkbox" name="sensor[]" id="checkedB[]" value="S"> Sentinel</td>
									</tr>
									<tr align="left">
										<td width="10%"></td>
										<td width="90%"><input type="checkbox" name="sensor[]" id="checkedB[]" value="T"> Temperature</td>
									</tr>
									<tr align="left">
										<td width="10%"></td>
										<td width="90%"><input type="checkbox" name="sensor[]" id="checkedB[]" value="B"> Smartboat</td>
									</tr>
									<tr align="left">
										<td width="10%"></td>
										<td width="90%"><input type="checkbox" name="sensor[]" id="checkedB[]" value="I"> Inclinometer</td>
									</tr>
								</table>
								<br><a class="register" onClick="downloadBtn()">Download<span class="arrow"> </span></a>
						  	</div>
						</div>
						<hr>
						<a class="link" onClick="serviceRegistration()"><br><h4>Register new service</h4></a>
						<hr>
						<a class="link" onClick="serviceCatalog()"><br><h4>Service Catalog</h4></a>
						<hr>
						<a class="link" onClick="logout()" style="color: green !important;"><br><h9>Logout</h9></a>
						<hr>
					</div>
					<div>
						<p class="deleteAccount"><a class="deleteAccount" onClick="deleteAccount()">Delete account</a></p>
						<p id="status"></p>
					</div>
				</div>
				<footer class="footer-distributed">
					<img src="images/logomF2C.png"  alt="mF2C Project" width="60px"> 
					<img src="images/logoEUH2020.png" alt="European Union's Horizon 2020" width="100px">
					<h5>This project has received funding from the European Union's Horizon 2020 research and innovation programme under grant agreement No 730929. The content of this site reflects only the mF2C Consortium view and not the official opinion of the European Commission. Responsibility for the use of the information therein lies entirely with the authors.</h5>
				</footer>
				<script>
					var modal = document.getElementById('modalForm');
					var span = document.getElementsByClassName("close")[0];
					var type = "";
					function showForm(agent)
					{
						var title = "Download the ";
						type = agent;
						switch(agent)
						{
							case 1:
								title = title + " Cloud Agent";
								break;
							case 2:
								title = title + " Fog Agent";
								break;
							case 3:
								title = title + "Micro Agent";
								break;
							default:
								title = title + "Agent";
								type = "U";
								break;
						}
						document.getElementById('mTitle').innerHTML = title;
						modal.style.display = "block";
					}

					span.onclick = function()
					{
						modal.style.display = "none";
					}

					window.onclick = function(event)
					{
						if (event.target == modal)
						{
							modal.style.display = "none";
						}
					}
					
					function chboxToggleActuator()
					{
						var none = document.getElementById('none_a');
						var checkboxes = document.getElementsByName('actuator[]');
						if (none.checked == true)
						{
							for(var i=0;i<checkboxes.length;i++)
							{
          						checkboxes[i].disabled = true;
    						}
						}
						else
						{
							for(var i=0;i<checkboxes.length;i++)
							{
          						checkboxes[i].disabled = false;
    						}
						}
					}
					
					function chboxToggleSensor()
					{
						var none = document.getElementById('none_s');
						var checkboxes = document.getElementsByName('sensor[]');
						if (none.checked == true)
						{
							for(var i=0;i<checkboxes.length;i++)
							{
          						checkboxes[i].disabled = true;
    						}
						}
						else
						{
							for(var i=0;i<checkboxes.length;i++)
							{
          						checkboxes[i].disabled = false;
    						}
						}
					}
					
					function downloadBtn()
					{
						var actuator_selection = getActuatorString();
						var sensor_selection = getSensorString();
						window.location = 'scripts/downloadAgent.php?actuator='+actuator_selection+'&sensor='+sensor_selection+'&agent='+type;
						modal.style.display = "none";
					}
					
					function getActuatorString()
					{
						var radio = document.getElementById('none_a');
						if (radio.checked == true)
							return "N";
						else
						{
							var str = "A-";
							var checkboxes = document.getElementsByName('actuator[]');
							var checkboxesChecked = [];
							for (var i=0; i<checkboxes.length; i++)
							{
     							if (checkboxes[i].checked)
								{
        							str = str + checkboxes[i].value;
     							}
  							}
							if (str == "A-")
								str = str + "-N";
							return str;
						}
					}
					
					function getSensorString()
					{
						var radio = document.getElementById('none_s');
						if (radio.checked == true)
							return "N";
						else
						{
							var str = "S-";
							var checkboxes = document.getElementsByName('sensor[]');
							var checkboxesChecked = [];
							for (var i=0; i<checkboxes.length; i++)
							{
     							if (checkboxes[i].checked)
								{
        							str = str + checkboxes[i].value;
     							}
  							}
							if (str == "S-")
								str = str + "-N";
							return str;
						}
					}
				</script>
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