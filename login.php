<? require 'classes/database.php'; ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Giriş sayfası</title>
</head>
<body>
<?php

if(isset($_POST['submit'])) {
	
	$loginUsername = $_POST['loginUsername'];
	$loginPassword = $_POST['loginPassword'];
	
	try
	{
		$query = $conn->prepare('SELECT * FROM user WHERE username=:username AND password=:password');
		$query->bindParam(':username', $loginUsername);
		$query->bindParam(':password', $loginPassword);
		$query->execute();
		
		if($query->rowCount() == 1) {
			echo 'Giriş yapıldı';
		}
		else
		{ ?>
        <form method="post">
            <input type="text" name="loginUsername">
            <input type="password" name="loginPassword">
            <input type="submit" value="Giriş" name="submit">
        </form>
        <p> Giriş sağlanamadı tekrar deneyiniz..</p>
	<? }
	}
	catch (PDOException $e)
	{
		print "Error Code is 001 because: " . $e->getMessage(). "<br/>";
	}
	}
else
{
?>
    <form method="post">
        <input type="text" name="loginUsername">
        <input type="password" name="loginPassword">
        <input type="submit" value="Giriş" name="submit">
    </form>
<?php } ?>

</body>
</html>