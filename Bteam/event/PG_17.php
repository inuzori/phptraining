<?php
session_start();

$header = 3;

require_once "db.inc.php";
require_once "auth.inc.php";

//--------------------
// ログイン認証済みでなければログインページへ移動
//--------------------
auth_confirm();

$id = $_GET["id"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Event Manager｜ユーザ情報編集の完了</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="js/jquery-2.2.3.js"></script>
<script>
<?php
require_once "jqheader.php";
?>
</script>
</head>
<body>
<div class="container">
<?php
require_once "header.php";
?>
<div id="nav"></div>
<h1>ユーザ編集</h1>
<p>ユーザの編集が完了しました。</p>
<p><a href="PG_13.php?id=<?php echo $id; ?>" >ユーザ詳細に戻る</a></p>
</div>
</body>
</html>