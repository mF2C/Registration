<?php
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	require 'vendor/autoload.php';

	$app = new \Slim\App;

	//REGISTER NEW DEVICE
	//Input: CIMIUsrID
	//Output: CIMIUsrID, deviceID and IDKey (json)
	$app->get('/ResourceManagement/Identification/RegisterDevice/{CIMIUsrID}', function (Request $request, Response $response, array $args)
	{
		include 'scripts/functions.php';
		$CIMIUsrID = $request->getAttribute('CIMIUsrID');
		$validFormat = Functions::validateCIMIUsrIDFormat($CIMIUsrID);
		//validate input length
		if (!$validFormat)
			echo '{"status": "412", "message": "Invalid input length"}';
		else
		{
			//validate if the user exists in the system
			$validUser = Functions::validateCIMIUsrID($CIMIUsrID);
			if (!$validUser)
				echo '{"status": "401", "message": "The provided user does not exist in the system"}';
			else
			{
				//get user email
				$usrEmail = Functions::getUsrEmail($CIMIUsrID);
				if ($usrEmail == "404")
					echo '{"status": "404", "message": "Unable to obtain the user email"}';
				else
				{
					//Calculate both, IDKey and deviceID
					$IDKey = Functions::generateHash($usrEmail);
					$IDKey = trim(strtolower($IDKey));
					$random = Functions::generateRandom(64);
					$deviceID = Functions::generateHash($IDKey . $random);
					echo '{"status": "201", "CIMIUsrID": "'.$CIMIUsrID.'", "deviceID": "'.$deviceID.'", "IDKey": "'.$IDKey.'"}';
				}
			}
		}
	});

	//REGISTER NEW DEVICE
	//Input: user credentials {usr, pwd} (json)
	//Output: CIMIUsrID, deviceID and IDKey (json)
	$app->post('/ResourceManagement/Identification/GetDeviceID', function (Request $request, Response $response, array $args)
	{
		include 'scripts/functions.php';
		//read the user and password from the json input
		$data = $request->getParsedBody();
		$usr = $data['usr'];
		$pwd = $data['pwd'];
		//validate the provided credentials
		$valid = Functions::validateUser($usr, $pwd);
		if (!$valid)
		{
			echo '{"status": "412", "message": "Invalid user credentials"}';
		}
		else
		{
			//get user email
			$usrEmail = Functions::getUsrEmail($usr);
			if ($usrEmail == "404")
				echo '{"status": "404", "message": "Unable to obtain the user email"}';
			else
			{
				//calculate the user IDKey
				$IDKey = Functions::generateHash($usrEmail);
				$IDKey = trim(strtolower($IDKey));
				//get deviceID
				$random = Functions::generateRandom(64);
				$deviceID = Functions::generateHash($IDKey . $random);
				echo '{"status": "201", "CIMIUsrID": "'.$usr.'", "deviceID": "'.$deviceID.'", "IDKey": "'.$IDKey.'"}';
			}
		}
	});

	//VALIDATE IDKey AGAINST CIMIUsrID
	//Input: CIMIUsrID, IDKey (json)
	//Output: status, message (json)
	$app->post('/ResourceManagement/Identification/validateIDKey', function (Request $request, Response $response, array $args)
	{
		include 'scripts/functions.php';
		//read the CIMIUsrID and IDKey from the json input
		$data = $request->getParsedBody();
		$CIMIUsrID = $data['CIMIUsrID'];
		$IDKey = $data['IDKey'];
		$validateCIMIUsrIDFormat = Functions::validateCIMIUsrIDFormat($CIMIUsrID);
		$validateIDKeyFormat = Functions::validateIDKeyFormat($IDKey);
		if (!$validateCIMIUsrIDFormat || !$validateIDKeyFormat)
			echo '{"status": "412", "message": "Invalid input format"}';
		else
		{
			$validUser = Functions::validateCIMIUsrID($CIMIUsrID);
			if (!$validUser)
				echo '{"status": "401", "message": "The provided user does not exist in the system"}';
			else
			{
				$usrEmail = Functions::getUsrEmail($CIMIUsrID);
				if ($usrEmail == "404")
					echo '{"status": "404", "message": "Unable to obtain the user email"}';
				else
				{
					$calculatedIDKey = Functions::generateHash($usrEmail);
					if ($IDKey != $calculatedIDKey)
						echo '{"status": "401", "message": "User is unauthorized"}';
					else
						echo '{"status": "202", "message": "User is authorized"}';;
				}
			}
		}
	});

	$app->run();
?>		