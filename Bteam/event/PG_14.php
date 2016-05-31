<?php
session_start();

require_once "db.inc.php";
require_once "auth.inc.php";

auth_confirm();

$header = 3;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$isValidated = TRUE;
	$name  = $_POST["name"];
	$login_id   = $_POST["login_id"];
	$login_pass  = $_POST["login_pass"];
	$group_id  = $_POST["group_id"];
	$type_id = $_POST["type_id"];

	if ($name === "") {
		$nameError = "氏名を入力して下さい";
		$isValidated = FALSE;
	}
	if ($login_id === "") {
		$idError = "ログインIDを入力して下さい";
		$isValidated = FALSE;
		}
	elseif (!ctype_alnum($login_id)) {
		$idError = "ログインIDは英数字のみを入力して下さい";
		$isValidated = FALSE;
	}
	if ($login_pass=== "") {
		$passError = "パスワードを入力して下さい";
		$isValidated = FALSE;
	}
	elseif (!ctype_alnum($login_pass)) {
		$passError = "パスワードは英数字のみを入力してください";
		$isValidated = FALSE;
	}

if ($isValidated == TRUE) {
try {
	$pdo=db_init();
$stmt = $pdo->prepare("INSERT INTO users
		                      (name, type_id, login_id, login_pass, group_id, created)
		                    VALUES
		                      (?, ?, ?, ?, ?, NOW())");
$stmt->execute(array($name, $type_id, $login_id, sha1($login_pass+$login_id), $group_id));
}
catch (PDOException $e) {
	echo $e->getMessage();
	exit;
 }
 }
}
else {
	$isValidated = FALSE;
}
if ($isValidated == TRUE) {
	header("Location: PG_15.php");
	exit;
}

if (isset($_POST["cancel"])) {
	header("Location: PG_12.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Event Manager｜ユーザ登録</title>
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
  <div id="main">
    <h1>ユーザ登録</h1>

    <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="type_id" value="1">
<br />
<p>氏名（必須）</p>

          <?php if (isset($nameError)): ?>
          <p class="error"><?php echo $nameError; ?></p>
          <?php endif; ?>
          <input type="text" size="40" name="name" placeholder="氏名" />

        <p>ログインID（必須）</p>

         <?php if (isset($idError)): ?>
         <p class="error"><?php echo $idError; ?></p>
         <?php endif; ?>
          <input type="text" size="8" name="login_id" placeholder="ログインID" />

        <p>パスワード（必須）</p>

         <?php if (isset($passError)): ?>
         <p class="error"><?php echo $passError; ?></p>
         <?php endif; ?>
          <input type="password" size="12" name="login_pass" placeholder="パスワード" />

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
		<option value="<?php echo $group["id"]; ?>"><?php echo $group["name"]; ?></option>
	<?php } ?>
	<?php endforeach; ?>
</select></p>
    <p>
      <input type="submit" name="cancel" value="キャンセル" class="cancel" />
      <input type="submit" name="add" value="登録" class="Registration" />
    </p>
    </form>
  </div>
</div>
</body>
</html>