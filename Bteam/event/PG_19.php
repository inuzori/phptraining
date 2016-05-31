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

try {
	//--------------------
	// データベースの準備
	//--------------------
	$pdo = db_init();
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($id));
 }catch (PDOException $e) {
    echo $e->getMessage();
    exit;
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Event Manager | ユーザ情報削除の完了</title>
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
<h1>ユーザ削除</h1>
<p>ユーザーの削除が完了しました。</p>
<p><a href="PG_12.php">ユーザー一覧へ戻る</a></p>
</div>
</body>
</html>