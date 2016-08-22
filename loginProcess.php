<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Giriş sayfası</title>
</head>
<body>

<?php include ("classes/database.php");
	
class User{
	private $dbh;
	
	public function __construct() {
		$this->dbh = new Connection();
		$this->dbh = $this->db->dbConnect();
	}
}
?>

</body>
</html>