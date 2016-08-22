<? 
require_once 'core/init.php';

if ($_GET['bharious'] == null) { // Hash değerini kontrol eder.
	header("Location: 404.php");
	exit;
}
else {
		
	// * Bharious(Hash) Data
	$bharious = $_GET['bharious'];
	
	$stmt = new Database();
	$sth  = $stmt->queryDBSecure('SELECT * FROM news WHERE bharious = "' . $bharious . '"');
	$result = $sth ->fetch(PDO::FETCH_ASSOC);
	
	?>
	<!doctype html>
	<html lang="tr">
	<html>
	<head>
	<meta charset="utf-8">
	<title><? echo $result['title']; /* News Title */ ?></title>
    
    <!-- CSS ---------------------------->
	<style>
	@charset "utf-8";
	
	/*** RESET */
	body, html, div, blockquote, img, label, p, h1, h2, h3, h4, h5, h6, pre, ul,
	ol, li, dl, dt, dd, form, a, fieldset, input, th, td
	{
	margin: 0; padding: 0; border: 0; outline: none;
	}
	
	/*** News Section ************************/
	.sectionNewsTitle {
		width: 100%;
		position: relative;
		text-align: center;
		background-color: rgba(255,255,255,0.30);
		color: rgba(255,255,255,1.00);
	}
	.sectionNewsTitle a{
		color: rgba(255,255,255,1.00);
	}
	
	/**** News Section **********************/
	.newsPic {
		width: 100%;
		height: 750px;
		max-height: 80%;
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center center;
	}
	
	/**** News main ****************************/
	.newItems {
		width: 100%;
		position: relative;
		float: left;
	}
	.newsTitleContent {
		width: 90%;
		height: 60px;
		margin: auto;
		padding: 10px;
		position: relative;
		border-bottom: thin solid rgba(250,168,87,1.00);
	}
	.newsTitleItem {
		position: relative;
		float: left;
	}
	#newsDate {
		padding-right: 6px;
		text-align: right;
		border-right: thin solid rgba(250,168,87,1.00);
		color: rgba(140,140,140,1.00)
	}
	#newsTitle {
		padding-left: 15px;
		font-size: 3em;
		font-weight: lighter;
	}
	.newsContent {
		width: 90%;
		margin: auto;
		padding: 10px;
	}
	.newsContent p {
		text-indent: 40px;
		font-size: 1em;
		margin-bottom: 13px;
	}
	
	/* Buttons */
	.buttonNav {
		cursor: pointer;
		position: relative;
		background-color: rgba(255,255,255,0.20);
	}
	#buttonPrev {
		width: 200px;
		height: 750px;
		float: left;
	}
	#buttonNext {
		width: 200px;
		height: 750px;
		float: right;
	}
	</style>    
    <!-- KS ----------------------------->
	<script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
	</head>
	
	<body>
	<header>
		<!-- src php ile hallolacak ilerii geri tuşları ayarlanacak -->
		<div class="newsPic" id="newsPic" style="background-image: url(img/newsPics/<? echo $result['picAdress']; ?>/1.jpg)">
			<div class="buttonNav" id="buttonNext"></div>
			<div class="buttonNav" id="buttonPrev"></div>    
		</div>
	</header>
	<main class="newItems">
		<article>
			<header class="newsTitleContent">
				<div class="newsTitleItem" id="newsDate">
					<?
						// DEACTIVE $x = new Date($result['date']);
						
						$temp = explode('-', $result['date']);
						echo $temp[2] . '<br />';
						echo $temp[1] . '<br />';
						echo $temp[0] . '<br />';
					?>
				</div>
				<div class="newsTitleItem" id="newsTitle">
					<? echo $result['title']; /* News Title */ ?> <span style="color: rgba(220,220,220,1.00)">
					<? echo '- ' . $result['visiting'] . ' kişi okudu (DEACTIVE)' ?> 
				</div>
			</header>
			<section class="newsContent">
				<p><? echo $result['context']; /* News Context */ ?></p>
			</section>    
		</article>
	</main>
	<footer>
	  
	</footer>
	<script>
	var count = 1;
	var directory = 'img/newsPics/<? echo $result['picAdress']; ?>/';
	
	$('#buttonNext').click(function(e) {
		count++;
		
		if(count === <? echo $result['number']; ?> + 1) count = 1;
		
		$('#newsPic').css("background-image", "url(" + directory + count + ".jpg)");	
	});
	
	$('#buttonPrev').click(function(e) {
		count--;
		
		if(count === 0) count = <? echo $result['number']; ?>;
		
		$('#newsPic').css("background-image", "url(" + directory + count + ".jpg)");	
	});
	</script></body>
	</html>
<?
}
?>