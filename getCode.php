<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php
	require "wxModel.php";
	$wechatObj = new wxModel();
	 echo '<img src="'.$wechatObj->getQrCode().'" alt="">'; 
	 ?>
	
</body>
</html>


