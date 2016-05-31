<?php

	$header=2;

	session_start();
	require_once "auth.inc.php";

	//--------------------
	// ログイン認証済みでなければログインページへ移動
	//--------------------
	auth_confirm();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Event Manager｜イベント情報編集の完了</title>
	<script src="js/jquery-2.2.3.js"></script>
	<link href="style.css" rel="stylesheet">

	<script>
	<?php require_once 'jqheader.php';?>
	</script>

</head>

<body>
	<div id="container">
	<?php require_once 'header.php';?>
	</div>

	<h1>イベント編集</h1>
	<p style="margin:10px 0px;">イベントの編集が完了しました。</p>
	<a href="PG_05.php?id=<?php echo $_SESSION["eventid"]?>">イベント詳細に戻る</a>
</body>
</html>