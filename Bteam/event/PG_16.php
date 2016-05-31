<?php
session_start();

$header = 3;

require_once "db.inc.php";
require_once "auth.inc.php";

//--------------------
// ログイン認証済みでなければログインページへ移動
//--------------------
auth_confirm();

if (!isset($_GET["id"])) {
  header("Location: PG_12.php");
  exit;
}
$id = $_GET["id"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Event Manager｜ユーザ編集</title>
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
<?php
try {
	//--------------------
	// データベースの準備
	//--------------------
	$pdo = db_init();
	//--------------------
	// 在庫リストの取得
	//--------------------
	$sql = "SELECT * FROM users WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array($id));
	$users = $stmt->fetch();

	$name = $users["name"];
	$login_id = $users["login_id"];
	$login_pass  = $users["login_pass"];
	$group_id = $users["group_id"];
}
catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}

//--------------------
// 「保存」ボタン
//--------------------
if (isset($_POST["save"])) {
	// バリデーション済みフラグの初期化
	$isValidated = TRUE;

	$name = $_POST["name"];
	if ($name === "") {
		$errorname = "氏名を入力してください";
		$isValidated = FALSE;
	}

	$login_id = $_POST["login_id"];
	if ($login_id === "") {
		$errorlogin_id = "ログインIDを入力してください";
		$isValidated = FALSE;
	}

	if($_POST["login_pass"] !== "") {
		$login_pass = $_POST["login_pass"];
	}else {
		$login_pass = $_POST["login_pass1"];
	}

	$group_id = $_POST["group_id"];

	if ($isValidated == TRUE) {
		try {
			$sql = "UPDATE users SET name = ?, login_id = ?, login_pass = ?, group_id = ? WHERE id=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array($name,$login_id,$login_pass,$group_id,$id));
			header("Location: PG_17.php?id=$id");
			exit;
		}
		catch (PDOException $e) {
			echo $e->getMessage();
			exit;
		}
	}
}

//--------------------
// 「キャンセル」ボタン
//--------------------
if (isset($_POST["cancel"])) {
	header("Location: PG_13.php?id=$id");
	exit;
}
?>
<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
<br />
<p>氏名（必須）<div class="error"><?php if (isset($errorname)) { echo $errorname; } ?></div></p>
<p><input type="text" size="40" name="name" value="<?php echo $name; ?>" placeholder="氏名"/></p>
<p>ログインID（必須）<div class="error"><?php if (isset($errorlogin_id)) { echo $errorlogin_id; } ?></div></p>
<p><input type="text" size="40" name="login_id" value="<?php echo $login_id; ?>" placeholder="ログインID"/></p>
<p>パスワード（変更の場合のみ）</p>
<p><input type="password" size="40" name="login_pass" placeholder="パスワード"/></p>
<input type="hidden" name="login_pass1" value="<?php echo $login_pass; ?>">
<p>所属グループ（必須）</p>
<?php
try {
	//--------------------
	// データベースの準備
	//--------------------
	$pdo = db_init();
	//--------------------
	// 在庫リストの取得
	//--------------------
	$sql = "SELECT * FROM groups";
	$stmt = $pdo->query($sql);
	$groups = $stmt->fetchAll();

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
<p><select name="group_id">
	<?php foreach ($groups as $group): ?>
	<?php if($group["name"]!="全員"){ ?>
		<option <?php if ($group_id === $group["id"]) echo 'selected="selected"'; ?> value="<?php echo $group["id"]; ?>"><?php echo $group["name"]; ?></option>
	<?php } ?>
	<?php endforeach; ?>
</select></p>
<input type="submit" class="white_button" name="cancel" value="キャンセル" />
<input type="submit" class="red_button" name="save" value="保存" />
</form>
</div>
</body>
</html>