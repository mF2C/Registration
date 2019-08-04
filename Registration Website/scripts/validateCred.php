<?php
	$user = $_GET['user'];
	$pass = $_GET['pass'];
	$data = array("sessionTemplate" =>array("href" => "session-template/internal", "username" => $user, "password" => $pass));   
	$data_string = json_encode($data);
	include 'cimi/endpoint.php';
	$ch = curl_init($endpoint.'/api/session');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	include 'cimi/setup.php';
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
	$result = curl_exec($ch);
	curl_close($ch);
	$obj = json_decode($result);
	$status =  $obj->status;
	if ($status == '201')
	{
		session_start();
		$_SESSION['mF2C_user'] = $user;
		$_SESSION['mF2C_pass'] = $pass;
		$_SESSION['mF2C_time'] = time();
		echo true;
	}
	else
	{
		echo false;
	}
?>