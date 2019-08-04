<?php
	class Functions
	{
		//Redirects to the given $location
		public static function redirect($location)
		{
			header("Location: " . $location);
			die();
		}
		
		//Returns true if the user already exists in the system
		public static function userExists($user)
		{
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
				return false;
			}
			else
			{
				return true;
			}
		}
		
		//Return true if the email already exists in the system
		public static function mailExists($mail)
		{
			include 'cimi/endpoint.php';
			$url = $endpoint.'/api/user?$filter=emailAddress="'.$mail.'"';
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
				return false;
			}
			else
			{
				return true;
			}
		}
		
		//Returns the user email sanitized. In case the email is not valid, this function will return false
		public static function sanitizeEmail($email)
		{
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);
			if (filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				return $email;
			}
			else
			{
				return "error";
			}
		}
		
		//Returns a random string of length $length
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
		
		//Create new user with CIMI
		public static function register($user, $email, $pass, $pass2)
		{
			$data = array("userTemplate" =>array("href" => "user-template/self-registration", "password" => $pass, "passwordRepeat" => $pass2, "emailAddress" => $email, "username" => $user));                                                                    
			$data_string = json_encode($data);
			include 'cimi/endpoint.php';
			$ch = curl_init($endpoint.'/api/user');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			include 'cimi/setup.php';
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
			$result = curl_exec($ch);
			curl_close($ch);
			$obj = json_decode($result);
			$status = $obj->status;
			$message = $obj->message;
			if ($status == '201')
				return "7";
			else
				return "MSG:".$message;
		}
		
		//Return true if the user $user is authorized 
		public static function validateCred($user, $pass)
		{
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
				return true;
			else
				return false;
		}
		
		//Returns the email address registered for $user
		public static function getUserEmail($user)
		{
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
			if ($status == "404")
			{
				return "error";
			}
			else
			{
				$email = $obj->emailAddress;
				return $email;
			}
		}
	}
?>