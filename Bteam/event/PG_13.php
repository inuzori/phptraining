<?php
session_start();

$header = 3;

require_once "db.inc.php";
require_once "auth.inc.php";

//--------------------
// ログイン認証済みでなければログインページへ移動
//--------------------
auth_confirm();

//--------------------
// IDの取得
//--------------------
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
<title>Event Manager｜ユーザ詳細</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="js/jquery-2.2.3.js"></script>
<script>
<?php
require_once "jqheader.php";
?>
</script>

<style type="text/css">
#screenLock{
	width: 100%;
	height: 100%;
	position: absolute;
	top: 0;
	left: 0;
	z-index: 99;
	background-color: rgba(0, 0, 0, 0.5);
	visibility: hidden;
}
#messageBox{
	width: 400px;
	height: 150px;
	position: absolute;
	top: 50%;
	left: 50%;
	margin-left: -175px;
	margin-top: -100px;
	z-index: 999;
	background-color: #fff;
	visibility: hidden;
	text-align: center;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
}
#messageTitle{
	padding: 2px 0;
}
#messageBody{
	text-align: left;
	width: 300px;
	height: 70px;
	padding: 10px;
	margin: 0 auto;
	background-color: #fff;
}
#messageButton{
	padding: 0 0 0 200px;
}
#messageButton button{
	width: 80px;
	height: 25px;
	margin: 5px 2px;
}
#yesBtn{
		font-family:"MingLiU-ExtB","HG教科書体";
		background: #d3381c;
		border: 1px solid #dcdddd;
		border-radius: 4px;
		-moz-border-radius: 4px;
		-webkit-border-radius: 4px;
		color: #FFF;
		padding: 5px 10px;
}
#noBtn{
		font-family:"MingLiU-ExtB","HG教科書体";
		background: #FFF;
		border: 1px solid #dcdddd;
		border-radius: 4px;
		-moz-border-radius: 4px;
		-webkit-border-radius: 4px;
		color: #111;
		padding: 5px 10px;
}

hr.style7 {
	border-top: 1px solid #ede4cd;
	border-bottom: 1px solid #fff;
}
</style>
<script type="text/javascript">
// ダイアログを表示
var MessageBox = (function(){
	// ******************************************
	// 関数名：閉じる
	// 説明　：メッセージボックスを閉じる
	// ******************************************
	function Hidden(){
		document.getElementById("screenLock").style.visibility = 'hidden';
		document.getElementById("messageBox").style.visibility = 'hidden';
	}
	// ******************************************
	// 関数名：表示
	// 説明　：メッセージボックスを表示する
	// ******************************************
	function Show(){
		document.getElementById("screenLock").style.visibility = 'visible';
		document.getElementById("messageBox").style.visibility = 'visible';
	}
	return {
		// ******************************************
		// 関数名：警告(alert)
		// 説明　：警告のメッセージボックスを表示する
		// ******************************************
		Alert: function(msgText){
			// ボタンの設定
			document.getElementById("yesBtn").style.display = 'inline';
			document.getElementById("noBtn").style.display = 'none';

			// メッセージを設定
			document.getElementById("messageBody").innerHTML = msgText;

			// 表示
			Show();

			// 閉じる
			document.getElementById("yesBtn").onclick = function(){ Hidden(); };
		},
		// ******************************************
		// 関数名：確認(confirm)
		// 説明　：確認のメッセージボックスを表示する
		// ******************************************
		Confirm: function(msgText, yesFunc, noFunc){
			// ボタンの設定
			document.getElementById("yesBtn").style.display = 'inline';
			document.getElementById("noBtn").style.display = 'inline';

			// メッセージを設定
			document.getElementById("messageBody").innerHTML = msgText;

			// 表示
			Show();

			// 「はい」ボタン
			document.getElementById("yesBtn").onclick = function(){ Hidden(); yesFunc(); };
			// 「いいえ」ボタン
			document.getElementById("noBtn").onclick = function(){ Hidden(); noFunc(); };
		}
	}
})();

function confirmTest(){
	MessageBox.Confirm(
		"<br>本当に削除してよろしいですか？",
		function(){ document.location.href = "PG_19.php?id=<?php echo $id; ?>"; },
		function(){ document.location.href = "javascript:window.history.back(-1);return false;"; }
	);
}

</script>

</head>
<body>
<div id="screenLock"></div>
<div id="messageBox">
	<div id="messageBody"></div><hr class="style7" />
	<div id="messageButton">
		<button id="yesBtn">OK</button>
		<button id="noBtn">Cancel</button>
	</div>
</div>

<div class="container">
<?php
require_once "header.php";
?>
<div id="nav"></div>
<h1>ユーザ詳細</h1>
<?php
try {
	//--------------------
	// データベースの準備
	//--------------------
	$pdo = db_init();
	//--------------------
	// 在庫リストの取得
	//--------------------
	$sql = "SELECT u.id, u.name AS u_name, g.name AS g_name FROM users u JOIN groups g ON u.group_id = g.id WHERE u.id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array($id));
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
<table class="table2">
<?php foreach ($users as $user): ?>
<tr>
	<th>ID</th>
	<?php $id = $user["id"]; ?>
	<td><?php echo $id; ?></td>
</tr>
<tr>
	<th>氏名</th>
	<td><?php echo $user["u_name"]; ?></td>
</tr>
<tr>
	<th>所属グループ</th>
	<td><?php echo $user["g_name"]; ?></td>
</tr>
<?php endforeach; ?>
</table>
<br />
<a href="PG_12.php" class="orange_button">一覧に戻る</a>
<a href="PG_16.php?id=<?php echo $user["id"]; ?>" class="white_button">編集</a>
<a href="#" class="black_button" onClick="confirmTest();">削除</a>
<!--  <a href="PG_19.php?id=<?php echo $user["id"]; ?>" class="black_button" onClick="javascript:return confirm('本当に削除してよろしいですか？')">削除</a>-->
</div>
</body>
</html>