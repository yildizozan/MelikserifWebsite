<?php
require_once 'Functions.php';

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
	
	/***********************
	*	Person
	************************/
	public function addPerson($phoneNumber, $gender, $firstName, $middleName, $familyName, $birthDate)
	{
		// Edit strings for register
		$gender = mb_convert_case($gender, MB_CASE_TITLE, "UTF-8");
		$firstName = mb_convert_case($firstName, MB_CASE_TITLE, "UTF-8");
		$middleName = mb_convert_case($middleName, MB_CASE_TITLE, "UTF-8");
		$familyName = mb_convert_case($familyName, MB_CASE_TITLE, "UTF-8");
		
		$register = datetimeTurkey();
	
		$stmt = $this->conn->prepare("INSERT INTO person (phoneNumber, register, gender, firstName, middleName, familyName, birthDate) VALUES (:phoneNumber, :register, :gender, :firstName, :middleName, :familyName, :birthDate)");
		$stmt->bindParam(':phoneNumber', $phoneNumber);
		$stmt->bindParam(':register', $register);
		$stmt->bindParam(':gender', $gender);
		$stmt->bindParam(':firstName', $firstName);
		$stmt->bindParam(':middleName', $middleName);
		$stmt->bindParam(':familyName', $familyName);
		$stmt->bindParam(':birthDate', $birthDate);
		$result = $stmt->execute();
		
		if ($result)
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
	
	public function getPeople()
	{
		$stmt = $this->conn->prepare("SELECT * FROM person");
		$stmt->execute();
		$people = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if ($people)
			return $people;
		else
			return false;
	}
	
	public function getPerson($phoneNumber)
	{
		$stmt = $this->conn->prepare("SELECT * FROM person WHERE phoneNumber = :phoneNumber");
		$stmt->bindParam('phoneNumber', $phoneNumber);
		$stmt->execute();
		
		$person = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if ($person)
			return $person;
		else
			return false;
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
		$stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_INT);
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
	
	/***********************
	*	News
	************************/
	public function addNews($picture, $title, $content, $author)
	{	
		$date = datetimeTurkey();
		
		$stmt = $this->conn->prepare("INSERT INTO news (picture, date, title, content, author) VALUES (:picture, :date, :title, :content, :author)");
		$stmt->bindParam(':picture', $picture);
		$stmt->bindParam(':date', $date);
		$stmt->bindParam(':title', $title, PDO::PARAM_STR);
		$stmt->bindParam(':content', $content, PDO::PARAM_STR);
		$stmt->bindParam(':author', $author);
		$result = $stmt->execute();
		
		if ($result)
		{
			$id = $this->conn->lastInsertId();
			$stmt = $this->conn->prepare("SELECT * FROM news WHERE id = :id");
			$stmt->bindParam(':id', $id);
			$stmt->execute();
			
			$news = $stmt->fetch(PDO::FETCH_ASSOC);

			return $news;
		}
		else
			return false;
	}
	
	public function getNews($min, $max)
	{
		$stmt = $this->conn->prepare("SELECT * FROM  `news` LIMIT ? , ?");
		$stmt->bindValue(1, $min, PDO::PARAM_INT);
		$stmt->bindValue(2, $max, PDO::PARAM_INT);
		$stmt->execute();
		
		$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if ($news)
			return $news;
		else
			return false;
	}
	
	public function updateNews($id, $title, $content)
	{
		$stmt = $this->conn->prepare("UPDATE news SET title = :title, content = :content WHERE id = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':title', $title, PDO::PARAM_STR);
		$stmt->bindParam(':content', $content, PDO::PARAM_STR);
		$result = $stmt->execute();
	}
	
	public function deleteNews($newsID)
	{
		$stmt = $this->conn->prepare("DELETE FROM news WHERE id = :id");
		$stmt->bindParam(':id', $newsID, PDO::PARAM_INT);
		$result = $stmt->execute();
		
		if ($result)
			return true;
		else
			return false;
	}
}
?>