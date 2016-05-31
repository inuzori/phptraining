<?php
session_start();

require_once "db.inc.php";
require_once "auth.inc.php";

$header =3;

//--------------------
// ログイン認証済みでなければログインページへ移動
//--------------------
//auth_confirm();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Event Manager | ユーザ情報登録の完了</title>
<link rel="stylesheet" href="style.css" />
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
  <div id="header">
  </div>
  <div id="main">
    <h1>ユーザ登録</h1>
    <p>ユーザーの登録が完了しました。</p>
    <p><a href="PG_12.php">ユーザー一覧へ戻る</a></p>
  </div>
  </div>
</body>
</html>