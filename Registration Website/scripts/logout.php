<?php
	session_start();
	try
	{
		session_destroy();
		echo true;
	}
	catch(Exception $e)
	{
		echo false;
	}
?>