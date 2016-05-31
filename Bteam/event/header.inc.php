<?php
	session_start();

	//if(!isset($_SESSION["login"])){
	//	header("Location:PG_01.php");
	//}
	$header=1;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Event Manager</title>
	<script src="js/jquery-2.2.3.js"></script>
	<link href="style.css" rel="stylesheet">

	<script>
	<?php require_once 'jqheader.php';?>
	</script>
</head>

<body>
	<div id=container>
		<?php require_once 'header.php';?>
	</div>
</body>
</html>