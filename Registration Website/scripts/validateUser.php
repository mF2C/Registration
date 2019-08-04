<?php
	$user = $_GET['user'];
	include 'cimi/endpoint.php';
	$url = $endpoint.'/api/user?$filter=username="'.$user.'"';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	include 'cimi/setup.php';
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','slipstream-authn-info: internal ADMIN'));
	$result = curl_exec($ch);
	curl_close($ch);
	$obj = json_decode($result);
	$res = $obj->count;
	if ($res == 0)
	{
		echo false;
	}
	else
	{
		echo true;
	}
?>
