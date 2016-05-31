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
	<li style="width:300px; font-size:18px; font-family:Papyrus; letter-spacing: 3px;"><div align="left">&nbsp;<img src="js/images/eventmanagericon.png" align="top">&nbsp;Event Manager</div></li>
	<li style="width:150px; font-size:20px; <?php if($header==1){ echo 'background-color:#e6b422; height: 30px;'; }else{ echo '" class="change'; } ?>"><a href="PG_03.php">本日のイベント</a></li>
	<li style="width:150px; font-size:20px; <?php if($header==2){ echo 'background-color:#e6b422; height: 30px;'; }else{ echo '" class="change'; } ?>"><a href="PG_04.php">イベント管理</a></li>
	<?php foreach($user as $user_one) {
			if($user_one["type_id"] == 2) {
	?>
	<li style="width:150px; font-size:20px; <?php if($header==3){ echo 'background-color:#e6b422; height: 30px;'; }else{ echo '" class="change'; } ?>"><a href="PG_12.php">ユーザ管理</a></li>
	<?php }else {?>
	<li style="width:150px; font-size:20px;"></li>
	<?php } ?>
	<li style="width:100px; font-size:20px;"></li>
	<li style="width:140px; font-size:20px; padding-right:10px; text-align:right;" class="dropdown"><img src="js/images/sample.png" align="top">&nbsp;<span style="vertical-align: middle; font-size: 100%;"><?php echo $user_one["name"]; ?></span>&nbsp;<span style="vertical-align: middle; font-size:40%;">▼</span></li>
	<?php } ?>
</ul>
<div class="child">
	<p><a class="logout" href="PG_02.php">&nbsp;&nbsp;ログアウト</a></p>
</div>
</header>