<?
require_once 'core/init.php';
require_once 'classes/Database.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Upload processing...</title>
<style type="text/css">
.error {
	padding: 10px;
	background: rgba(201,32,35,1.00);
	color: rgba(255,255,255,1.00);
	margin-bottom: 3px;
}
.success {
	padding: 10px;
	background: rgba(0,177,106,1.00);
	color: rgba(255,255,255,1.00);
	margin-bottom: 3px;
}
</style>
</head>

<body>
<?php
	if ( isset($_FILES['images']) ) {
		
		// Create unique directory for files
		$thisDir = getcwd();
		$newDir = date('Ymd-His');
		$dir = $thisDir . '/img/newsPics/' . $newDir;
		
		// Control directory
		while(is_dir($dir)) {
			$newDir = date('Ymd-His');
			$dir = $thisDir . '/img/newsPics/' . $newDir;
		}
		
		//* Create folder
		if(mkdir($dir, 0755)) {
			
			// Count is files names;
			$count = 1;

			// * File number
			$fileCount = 0;
	
			// Loop for files
			foreach($_FILES['images']['error'] as $key => $imgError ) {
				
				//* Assignment variable
				$imgName	=	$_FILES['images']['name'][$key];
				$imgType	=	$_FILES['images']['type'][$key];
				$imgSize	=	$_FILES['images']['size'][$key];
				$imgTemp	=	$_FILES['images']['tmp_name'][$key];
				
				//* Need to explode extensiton and than extension must be small character.
				$imgExt = explode('.', $imgName);
				$imgExt = strtolower(end($imgExt));
				
				//* New image name (1.jpg, 2.jpg, 3.jpg... etc)
				$imgNameNew = $count . '.' . $imgExt;
				
				if($imgSize < 3145728)	// Image size control
					if($imgType == 'image/jpeg') // Image type control
						if (move_uploaded_file($imgTemp, $dir . '/' . $imgNameNew)) {
							echo '<div class="success">' . $_FILES['images']['name'][$key] . ' yüklendi.</div>'; // Notice for successful.
							$fileCount++;
						}
					else echo '<div class="error">' . $_FILES['images']['name'][$key] . ' dosyasının türü doğru değil!</div>';	// File extension control
				else echo '<div class="error">' . $_FILES['images']['name'][$key] . ' dosyasının boyutu çok fazla!</div>'; // Size control
	
				$count = $count + 1; // Loop for next file name.
			}

			// * Post data
			$newsTitle = $_POST['newsTitle'];
			$newsDate = $_POST['newsDate'];
			$newsContext = $_POST['newsContext'];
			$newsBharious = $_POST['newsBharious'];
			$newsPicAdress = $newDir;

			try 
			{
				// * Database connect.
				$conn = new Database();
			
				// * Prepare for insert data
				$stmt = $conn->prepareDBSecure( 'INSERT INTO news (title, context, date, picAdress, bharious, number) VALUES (:newsTitle, :newsContext, :newsDate, :newsPicAdress, :newsBharious, :number)');
				$stmt->bindParam(':newsTitle', $newsTitle, PDO::PARAM_STR, 50);
				$stmt->bindParam(':newsContext', $newsContext, PDO::PARAM_STR, 999);
				$stmt->bindParam(':newsDate', $newsDate);
				$stmt->bindParam(':newsPicAdress', $newsPicAdress);
				$stmt->bindParam(':newsBharious', $newsBharious);
				$stmt->bindParam(':number', $fileCount); // Maksimum dosya adedi
			
				// Run.
				if( $stmt->execute() )
				echo ' MYSQL SUCCESS';
			}
			catch (PDOException $e)
			{
				echo 'Error code is: 3665';
				echo $e->getMessage();
			}
			/**********************/

		
		}
		else echo 'Error code is: 8652'; //* Klasör oluşturulamıyor.
	}
	else echo 'Sanırm meraklı bir gezinti..<br>Hmm.. çok severim.<br><strong>Sen</strong> bi iletişime geç!</br>';
?>
</body>
</html>
