<?php
/*
$array = array('lastname', 'email', 'phone');
$comma_separated = implode(" ", $array);

echo "<pre>"; print_r($array); echo "</pre>";

echo $comma_separated; // lastname,email,phone
*/
?>
<?php 
	include ("../inc/Database.php");

	//if (isset($_POST["min"]) && isset($_POST["max"])) 

	$db = new Database();
	
	$allNews = $db->getNews(0, 30);
			
	foreach ($allNews as $index => $ent)
	{
		// Haberi yazan kişinin databaseden kim olduğunu bulup getirmemiz gerekiyor.
		$getAuthor = implode(" ", $db->getAuthor($ent["author"]));

		$results[$index]["title"] = $ent["title"];
		$results[$index]["content"] = $ent["content"];
		$results[$index]["author"] = $getAuthor;
		$results[$index]["date"] = $ent["date"];
	}
	
	echo json_encode($results);
?>