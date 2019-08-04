<?php
	session_start();
	$user = $_SESSION['mF2C_user'];
	include 'cimi/endpoint.php';
	$ch = curl_init($endpoint.'/api/user/' . $user);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	include 'cimi/setup.php';
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'slipstream-authn-info: internal ADMIN'));
	$result = curl_exec($ch);
	curl_close($ch);
	$obj = json_decode($result);
	$status = $obj->status;
	if ($status == "403")
	{
		echo "403";
	}
	else
	{
		if ($status == "404")
		{
			echo "404";
		}
		else
		{
			$email = $obj->emailAddress;
			echo $email;
		}
	}
?>