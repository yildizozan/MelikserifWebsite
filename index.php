<?
require_once 'core/init.php';
require_once 'classes/Database.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ana Sayfa</title>

<!-- CSS ---------------------------->
<link href="css/reset.css" rel="stylesheet" type="text/css">
<link href="css/typography.css" rel="stylesheet" type="text/css">
<link href="css/structure.css" rel="stylesheet" type="text/css">
<link href="css/colors.css" rel="stylesheet" type="text/css">
<link href="css/popup.css" rel="stylesheet" type="text/css">

<!-- Plugins ---->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>

<body>
	<!-- POPUP DEACTIVE
    <article class="popup" id="popup">
    <span class="fa fa-close fa-2x" id="buttonPopupClose" onClick="hidePopup()"></span>
    	<div class="popupTitle">Dikkat</div>
        <div class="popupContext">Aidatları ödeyin!</div>
    </article>
    ---->
    
    <!-- Top <Nav></Nav> Menu  DEACTIVE
    <nav class="navigationTop">
    	<div class="buttonTopMenuElement navigationFontSize"><a href="#">Haberler</a></div>
    	<div class="buttonTopMenuElement navigationFontSize"><a href="#">Big Boss</a></div>
    	<div class="buttonTopMenuElement navigationFontSize"><a href="#">Dernek</a></div>
    	<div class="buttonTopMenuElement navigationFontSize"><a href="#">Kökenlerimiz</a></div>
    </nav>
    --------------->
    
    <!-- Section Logo --------------->
	<article>
    	<section class="sectionFrameCommon" id="sectionLogo">
        </section>

               <!-- SECTION NEWS ------------>
        <section class="sectionFrameCommon" id="sectionNews">
            <div class="sectionNewsItemBorder">

        <?
            // Database connect.
            $stmt = new Database();

            // Prepare for insert data, (ORDER BY DESC id LIMIT 6)
            $stmt = $stmt->queryDBSecure("
			SELECT * 
			FROM  `news` 
			ORDER BY  `news`.`id` DESC 
			LIMIT 0 , 6
			");
			
			// Son 6 resimi döndürecek olan döngü
            foreach ($stmt as $key) {
        ?>

            	<div class="sectionNewsItem" style="background-image:url(img/newsPics/<? print_r($key['picAdress']) ?>/1.jpg)">
                	<div class="sectionNewsDate"><? print_r($key['date']); ?></div>
                	<a href="news.php?bharious=<? print_r($key['bharious']); ?>"><div class="sectionNewsTitle"><? print_r($key['title']); ?></div></a>
                </div>
        <?
            }
            $stmt = null;
        ?>

			</div>
        </section>

        
        
        <!-- SECTION BIG BOSS --------->
        <?
		$stmt = new Database();
		
		$stmt = $stmt->queryDBSecure("
		SELECT * 
		FROM  `bigBoss` 
		ORDER BY  `bigBoss`.`id` DESC 
		LIMIT 1
		");
		?>
        <section class="sectionFrameCommon" id="sectionBigBoss" >
        	<div class="sectionBBBorder">
            	<? foreach($stmt as $key) { ?>
            	<div class="sectionBBPic">
                	<div class="bigBossPic" style="background-image: url(img/bigboss/<? echo $key['picAddress']; ?>.jpg)
"></div>
                </div>
                <div class="sectionBBBio bigBossBio">
					<? echo $key['type'] . ' ' . $key['name']; ?><br />
                    <? print_r($key['biography']);?>
                    </div>
                <? } ?>
            </div>
        </section>

		<!-- SECTION ORG ------------------>
        <section class="sectionFrameCommon" id="sectionOrganisation">
        
        </section>
        
        <!-- SECTION ROOTS ------------->
        <?
        	$stmt = new Database();
			$stmt = $stmt->queryDBSecure("
			SELECT *
			FROM  `death` 
			ORDER BY  `death`.`death` DESC 
			LIMIT 0 , 3");
		?>
        <section class="sectionFrameCommon" id="sectionRoots">
        	<div class="sectionRootsBorder">
                <? foreach($stmt as $key) { ?>            
                <div class="sectionRootsPicBorder">
                    <div class="sectionRootsPic" style="background-image: url(img/deaths/<? echo $key['picAddress']; ?>.jpg)"></div>
                    <div class="rootWho rootsFontSize"><? echo $key['name']; ?><br>(<? echo $key['born'] . ' - ' . $key['death'];?>)</div>
                </div>
                <div class="rootsSpace"></div>
                <? } ?>            
            </div>
        </section>
    </article>
    <article class="maps">
        <div id="map" style="width: 100%; height: 300px"></div>
    </article>
    <footer>
    <a href="https://www.google.com.tr/url?sa=t&rct=j&q=&esrc=s&source=web&cd=10&ved=0ahUKEwi54p6FiZPLAhXIEywKHShVAUEQFgg9MAk&url=http%3A%2F%2Fwww.yildizozan.com%2F&usg=AFQjCNF5eiqO2XoCoXxM9VywQxLu81D1SA&cad=rja">asd</a>

    </footer>
    </body>
<!-- Popup -->
<script type="text/javascript">
function hidePopup() {
	document.getElementById("popup").style.display = "none";
}
</script>

<!-- Google Maps Api -->
<script>
function initMap() {
	var yurtbasi = {lat:39.889772, lng: 38.949003};

    var map = new google.maps.Map(document.getElementById('map'), {
        center: yurtbasi,
        scrollwheel: false,
        zoom: 15,
		mapTypeId: google.maps.MapTypeId.SATELLITE
    });

    var marker = new google.maps.Marker({
        map: map,
        position: yurtbasi,
        title: 'Yurtbaşı Köyü Yeni Yerleşkesi'
    });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzXIyyhiZ7zdfXKUYn-YPvDMmik-V-sBw&callback=initMap" async defer></script>
</html>
https://www.google.com.tr/url?sa=t
&rct=j
&q=
&esrc=s
&source=web
&cd=10
&ved=0ahUKEwi54p6FiZPLAhXIEywKHShVAUEQFgg9MAk
&url=http%3A%2F%2Fwww.yildizozan.com%2F
&usg=AFQjCNF5eiqO2XoCoXxM9VywQxLu81D1SA&cad=rja
