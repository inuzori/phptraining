<?php

require_once "db.inc.php";
require_once "auth.inc.php";

$login_id = $_SESSION["id"];

try {
	$pdo=db_init();
$stmt = $pdo->prepare("SELECT * from users where login_id=?");
$stmt->execute(array($login_id));
$user = $stmt->fetchAll();
$pdo = null;
}
catch (PDOException $e) {
	echo $e->getMessage();
	exit;
 }

?>

<header>
<ul id="menu" style="list-style:none;">
	<li style="width:300px; font-size:20px; font-family:Impact; letter-spacing: 5px;"><div align="left">&nbsp;&nbsp;Event Manager</div></li>
	<li style="width:150px; <?php if($header==1){ echo 'background-color:orange;'; }else{ echo '" class="change'; } ?>"><a href=#>本日のイベント</a></li>
	<li style="width:150px; <?php if($header==2){ echo 'background-color:orange;'; }else{ echo '" class="change'; } ?>"><a href=#>イベント管理</a></li>
	<li style="width:150px; <?php if($header==3){ echo 'background-color:orange;'; }else{ echo '" class="change'; } ?>"><a href="sample.php">ユーザ管理</a></li>
	<li style="width:100px;"></li>
	<?php foreach($user as $users): ?>
	<li style="width:140px; padding-right:10px; text-align:right;" class="dropdown"><img src="js/images/sample.png" align="center">&nbsp;&nbsp;<?php echo $users["name"]; ?>&nbsp;<font size="1">▼</font></li>
	<?php endforeach; ?>
</ul>
<div class="child">
	<p><a class="logout" href=PG_02.php>ログアウト</a></p>
</div>
</header>