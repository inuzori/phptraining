<?php
session_start();

require_once "db.inc.php";
require_once "auth.inc.php";

$header =3;

$_SESSION = array();
$params = session_get_cookie_params();
setcookie(session_name(), "", time() - 36000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
);
session_destroy();

?>

<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Event Manager｜ログアウト</title>
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
<h1>ログアウト</h1>
<p>ログアウトしました。</p>
<p><a href="PG_01.php">ログイン画面に戻る</a></p>
  </div>
</body>
</html>