<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
</head>
<body>
<form id="imgUploadForm" action="newsAddProcess.php" method="post" enctype="multipart/form-data">
    <input type="text" name="newsTitle" value="Başlık">
    <input type="hidden" name="newsBharious" value="<? echo md5(uniqid(mt_rand())); /* Random sayı oluşturur token */ ?>">
    <input type="date" name="newsDate"><br />
    <textarea name="newsContext" rows="4" cols="50"></textarea><br />
    <input type="file" name="images[]" multiple value="Seç" />
    <input type="submit" value="Dosyayı Gönder" />
</form>
</body>
</html>