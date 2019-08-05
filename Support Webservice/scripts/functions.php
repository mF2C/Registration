<?php
	class Functions
	{
		//validates whether the $CIMIUsrID meets the expected format 
		public static function validateCIMIUsrIDFormat($CIMIUsrID)
		{
			//false=invalid; true=valid
			$length = strlen($CIMIUsrID);
			if ($length <= 7)
				return false;
			else
				return true;
		}
		
		//validates whether the $IDKey meets the expected format
		public static function validateIDKeyFormat($IDKey)
		{
			//false=invalid; true=valid
			$length = strlen($IDKey);
			if ($length != 128)
				return false;
			else
			{
				if (!ctype_xdigit($IDKey))
					return false;
				else
					return true;
			}
		}
		
		//Returns random string of length $length
		public static function generateRandom($length)
		{
			$characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
			$charactersLength = strlen($characters);
			$randomStr = '';
			for ($i = 0; $i < $length; $i++)
			{
				$randomStr .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomStr;
		}
		
		//Returns the hash value for the input $str
		public static function generateHash($str)
		{
			$ans = hash('sha512', $str);
			return $ans;
		}
		
		public static function validateUser($usr, $pwd)
		{
			$valid = false;
			$data = array("sessionTemplate" =>array("href" => "session-template/internal", "username" => $usr, "password" => $pwd));   
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
				$valid = true;
			return $valid;
		}
		
		//Validates whether a given CIMIUsrID exists in the system
		public static function validateCIMIUsrID($CIMIUsrID)
		{
			$valid = false;
			include 'cimi/endpoint.php';
			$url = $endpoint.'/api/user?$filter=username="'.$CIMIUsrID.'"';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			include 'cimi/setup.php';
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','slipstream-authn-info: internal ADMIN'));
			$result = curl_exec($ch);
			curl_close($ch);
			$obj = json_decode($result);
			$res = $obj->count;
			if ($res > 0)
				$valid = true;
			return $valid;
		}
		
		//Returns the email for a given user
		public static function getUsrEmail($usr)
		{
			$usrEmail = "";
			include 'cimi/endpoint.php';
			$ch = curl_init($endpoint.'/api/user/' . $usr);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			include 'cimi/setup.php';
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'slipstream-authn-info: internal ADMIN'));
			$result = curl_exec($ch);
			curl_close($ch);
			$obj = json_decode($result);
			$status = $obj->status;
			if ($status == "404")
				return "404";
			else
				$usrEmail = $obj->emailAddress;
			return $usrEmail;
		}
	}
?>