<?php
function randomText($bottom, $top)
{
	$chars = preg_split('//', 'QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz0123456789', -1);
	
	shuffle($chars);
		$word = implode("", $chars);
		$word = substr($word, $bottom, $top);
		
		return $word;
}

function encrypt($password, $salt)
{
	$saltLeft = sha1($salt);
	$saltRight = base64_encode($salt);
	$hash = sha1($saltLeft . $password . $saltRight);
	
	return $hash;
}

function passGenerator()
{
	$pass = rand(1000, 9999);
	
	return $pass;
}

function datetimeTurkey()
{
	$timezone  = +3; //(GMT +3:00) EST (Turkey) 
	return gmdate("Y-m-d H:i:s", time() + 3600*($timezone+date("I")));
}

?>