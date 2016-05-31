<?php
session_start();

require_once "db.inc.php";
require_once "auth.inc.php";

//--------------------
// 変数の初期化
//--------------------
$id = "";
$pass = "";

//--------------------
// ログイン処理
//--------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // POSTされたデータを取得
  $id   = $_POST["id"];
  $pass = $_POST["pass"];

  // バリデーション済みフラグの初期化
  $isValidated = TRUE;

  // ログインIDのバリデーション
  if ($id === "") {
    // エラー
    $idError = "ログインIDを入力してください。";
    $isValidated = FALSE;
  }

  // パスワードのバリデーション
  if ($pass === "") {
    // エラー
    $passError = "パスワードを入力してください。";
    $isValidated = FALSE;
  }

  // エラーが無ければ認証チェック
  if ($isValidated == TRUE) {
    try {
      $pdo = db_init();
      $sql = "SELECT * FROM users
              WHERE
                login_id=?
              AND
                login_pass=?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array($id,sha1($pass+$id)));
      $info = $stmt->fetch();
      if ($info != FALSE) {
        // ログイン認証成功
        // セッション変数に情報を格納し、在庫一覧画面へ移動
        $_SESSION["id"]   = $id;
        $_SESSION["auth"] = TRUE;
        $_SESSION["userid"]=$info["id"];
        header("Location: PG_03.php");
        exit;
      }
      else {
        // ログイン認証失敗
        $loginError = "ログインIDまたはパスワードに誤りがあります。";
      }
    }
    catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>Event Manager｜ログイン</title>
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
require_once "logheader.php";
?>
<br><br>
<form action="" method="post" autocomplete="off">
    <?php if (isset($idError)): ?>
    <p class="error"><?php echo $idError; ?></p>
    <?php endif; ?>
    <?php if (isset($loginError)): ?>
    <p class="error"><?php echo $loginError; ?></p>
    <?php endif; ?>
    <input type="text" name="id" value="" placeholder="ログインID" />
    <?php if (isset($passError)): ?>
    <p class="error"><?php echo $passError; ?></p>
    <?php endif; ?>
    <input type="password" name="pass" value="" placeholder="パスワード" />
    <input type="submit" value="ログイン" class="login_button" />
    </form>
  </div>
</body>
</html>