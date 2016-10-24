<?php

include ("../inc/Database.php");

if (isset($_POST["phoneNumber"]))
{
	
	// Post datasını zararlı şeylerden temizliyoruz
	$phoneNumber = $_POST["phoneNumber"];

	// Objemizi oluşturuyoruz database bilgileri belli olduğundan default constructor halledecek
	$db = new Database();
	
	// Eğer girilen numara databasede kayıtlı ise checkUser() true döner
	// login için kayıtlı olmamasını sağlayacağız.
	if ($db->checkPerson($phoneNumber))
	{
		// Temproray pass for login
		$pass = passGenerator();
		$updatePass = $db->updatePassword($phoneNumber, $pass);
		
		// Get person information
		$person = $db->getPerson($phoneNumber);
		
		$response["person"]["error"] = false;
		$response["person"]["phoneNumber"] = $person["phoneNumber"];
		$response["person"]["password"] = $person["password"];	// sistemde bir açık demek
		$response["person"]["register"] = $person["register"];
		$response["person"]["gender"] = $person["gender"];
		$response["person"]["firstName"] = $person["firstName"];
		$response["person"]["middleName"] = $person["middleName"];
		$response["person"]["familyName"] = $person["familyName"];
		$response["person"]["birthDate"] = $person["birthDate"];
		
		echo json_encode($response);
	} 
	else 
	{
		// User is not found with the credentials
		$response["user"]["error"] = true;
		echo json_encode($response);
	}
	
} 
else 
{
	// Requiter post param is missing
	$response["user"]["error"] = true;
	echo json_encode($response);
}
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<form method="post">
<input name="phoneNumber">
<input type="submit">
</form>
</body>
</html>
