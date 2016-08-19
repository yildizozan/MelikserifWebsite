<?php
class Database
{
	private $conn;
	
	function __construct()
	{
			require_once 'inc/Secret.php';	
			
			// Connection to mysql database with PDO
			$this->conn = new PDO('mysql:host=localhost; dbname=yildizoz_melikserifkoyu', DB_USER, DB_PASSWORD);
			//$this->conn->exec("set names utf8");
			
	}
	
	function __destruct ()
	{
		$this->conn = NULL;
	}
	
	public function addPerson($phoneNumber, $firstName, $middleName, $familyName, $birthDate)
	{
		// Register Date
		$register = date("Y-m-d H:i:s");
	
		$stmt = $this->conn->prepare("INSERT INTO person (phoneNumber, register, firstName, middleName, familyName, birthDate) VALUES (:phoneNumber, :register, :firstName, :middleName, :familyName, :birthDate)");
		$stmt->bindParam(':phoneNumber', $phoneNumber);
		$stmt->bindParam(':register', $register);
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
	} // end function register
	
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