<?php
class Database
{
	private $conn;
	
	function __construct()
	{
			require_once 'Secret.php';	
			
			// Connection to mysql database with PDO
			$this->conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conn->exec("set names utf8");
			
	}
	
	function __destruct ()
	{
		$this->conn = NULL;
	}
	
	// Register
	public function addPerson($phoneNumber, $gender, $firstName, $middleName, $familyName, $birthDate)
	{
		// Edit strings for register
		$gender = mb_convert_case($gender, MB_CASE_TITLE, "UTF-8");
		$firstName = mb_convert_case($firstName, MB_CASE_TITLE, "UTF-8");
		$middleName = mb_convert_case($middleName, MB_CASE_TITLE, "UTF-8");
		$familyName = mb_convert_case($familyName, MB_CASE_TITLE, "UTF-8");
		
		// Register Date
		$timezone  = +3; //(GMT +3:00) EST (Turkey) 
		$register = gmdate("Y-m-d H:i:s", time() + 3600*($timezone+date("I")));
	
		$stmt = $this->conn->prepare("INSERT INTO person (phoneNumber, register, gender, firstName, middleName, familyName, birthDate) VALUES (:phoneNumber, :register, :gender, :firstName, :middleName, :familyName, :birthDate)");
		$stmt->bindParam(':phoneNumber', $phoneNumber);
		$stmt->bindParam(':register', $register);
		$stmt->bindParam(':gender', $gender);
		$stmt->bindParam(':firstName', $firstName);
		$stmt->bindParam(':middleName', $middleName);
		$stmt->bindParam(':familyName', $familyName);
		$stmt->bindParam(':birthDate', $birthDate);
		$result = $stmt->execute();
		
		if	($result)
		{
			$stmt = $this->conn->prepare("SELECT * FROM person WHERE phoneNumber = :phoneNumber");
			$stmt->bindParam(':phoneNumber', $phoneNumber);
			$stmt->execute();
			
			$user = $stmt->fetch(PDO::FETCH_ASSOC);

			return $user;
		}
		else
		{
			return false;	
		}
	}
	
	public function getPerson()
	{
		
	}
	
	public function updatePerson()
	{
	}
	
	public function deletePerson()
	{
	}
	
	// Login
		public function login($phoneNumber)
	{
		$stmt = $this->conn->prepare("SELECT * FROM users WHERE phoneNumber = :phoneNumber");
		$stmt->bindParam(':phoneNumber', $phoneNumber);
		$stmt->execute();

		$user = $stmt->fetch(PDO::FETCH_ASSOC);		
		return $user;
	}
	
	// User control edilir. Eğer kişi databasede kayıtlı ise true döndürülür.
	public function checkUser($phoneNumber)
	{
		$stmt = $this->conn->prepare("SELECT * FROM users WHERE phoneNumber = :phoneNumber");
		$stmt->bindParam(':phoneNumber', $phoneNumber);
		$stmt->execute();
		
		if($stmt->rowCount() > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	// Generate edilmiş olan pass ilgili database bölümüne kayıt edilecek.
	public function auth($phoneNumber, $pass) {
		$stmt = $this->conn->prepare("UPDATE users SET password = :password WHERE phoneNumber = '" . $phoneNumber . "'");
		$stmt->bindParam(':password', $pass);
		$result = $stmt->execute();
		
		return $result;
	}
	
}
?>