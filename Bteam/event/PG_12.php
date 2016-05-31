<?php
session_start();

$header = 3;

require_once "db.inc.php";
require_once "auth.inc.php";

//--------------------
// ログイン認証済みでなければログインページへ移動
//--------------------
auth_confirm();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ユーザ一覧</title>
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
<h1>ユーザ一覧</h1>
<?php
try {
	//--------------------
	// データベースの準備
	//--------------------
	$pdo = db_init();
	//--------------------
	// 在庫リストの取得
	//--------------------
	$sql = "SELECT u.id, u.name AS u_name, g.name AS g_name FROM users u JOIN groups g ON u.group_id = g.id ORDER BY u.id DESC";
	$stmt = $pdo->query($sql);
	$hits = $stmt->rowCount();
	//   echo $hits;
	//   exit;

	$numPages = ceil($hits / 5);

	if(isset($_GET["p"])) {
		$page = $_GET["p"];
		$back = $_GET["p"] - 1;
		$next = $_GET["p"] + 1;
	}else {
		$page = 1;
		$back = "";
		$next = 2;
	}


	$offset = ($page - 1) * 5;

	$sql = "SELECT u.id, u.name AS u_name, g.name AS g_name FROM users u JOIN groups g ON u.group_id = g.id ORDER BY u.id DESC LIMIT {$offset},5";
	$stmt = $pdo->query($sql);
	$users = $stmt->fetchAll();

	//--------------------
	// DB接続の解放
	//--------------------
	$pdo = null;
}
catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}
?>
<table class="pages"><tr>
<th class="notnow">
<?php if($page == 1) {
	echo "&#8810;";
}else {?>
	<a href="?p=<?php echo $back; ?>">&#8810;</a>
<?php }?>
</th>
<?php for($i=1; $i<=$numPages; $i++) {
	if($page == $i) {
?>
<td class="now">
		<?php echo $i; ?>
</td>
	<?php }else { ?>
<td class="notnow">
		<a href="?p=<?php echo $i; ?>"><?php echo $i; ?></a>
</td>
	<?php }?>
<?php }?>
<th class="notnow">
<?php if($page == $numPages) {
	echo "&#8811;";
}else {?>
	<a href="?p=<?php echo $next; ?>">&#8811;</a>
<?php }?>
</th>
</tr></table>
<table class="table1">
<tr>
	<th>ID</th>
	<th>氏名</th>
	<th>所属グループ</th>
	<th>詳細</th>
</tr>
<?php foreach ($users as $user): ?>
<tr>
	<td><?php echo $user["id"]; ?></td>
	<td><?php echo $user["u_name"]; ?></td>
	<td><?php echo $user["g_name"]; ?></td>
	<td><a href="PG_13.php?id=<?php echo $user["id"]; ?>" class="white_button">詳細</a></td>
</tr>
<?php endforeach; ?>
</table>
<br />
<a href="PG_14.php" class="red_button">ユーザの登録</a>
</div>
</body>
</html>