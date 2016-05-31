<?php
	require_once 'check.inc.php';
	require_once 'db.inc.php';

	$header=2;
	$isValidated=true;

	session_start();
	require_once "auth.inc.php";

	//--------------------
	// ログイン認証済みでなければログインページへ移動
	//--------------------
	auth_confirm();

	$rel=check(array("name","start","finish","place","group","message","eventid"));

	$pdo=db_init();
	$stmt=$pdo->query("SELECT * FROM groups");
	$groups=$stmt->fetchAll(PDO::FETCH_ASSOC);

	if($_SERVER["REQUEST_METHOD"]==="GET"){
		$eventid=$_GET["id"];
		$_SESSION["eventid"]=$eventid;
		$rel["eventid"]=$eventid;

		try{
			$pdo=db_init();
			$stmt=$pdo->prepare("SELECT * FROM events WHERE id=?");
			$stmt->execute(array($eventid));
			$events=$stmt->fetchAll(PDO::FETCH_ASSOC);

			$rel["name"]=$events[0]["title"];
			$rel["start"]=$events[0]["start"];
			$rel["finish"]=$events[0]["end"];
			$rel["place"]=$events[0]["place"];
			$rel["group"]=$events[0]["group_id"];
			$rel["message"]=$events[0]["detail"];

		}catch(PDOException $e){
			$e->getMessage();
			exit;
		}
	}

	if(isset($_POST["cancel"])){
		header("Location:PG_05.php?id=".$_SESSION["eventid"]);
	}

	if(isset($_POST["save"])){

		if(empty($rel["name"])){
			$errorName="タイトルが未入力です。";
			$isValidated=false;
		}

		if(empty($rel["start"])){
			$errorStart="開始日時が未入力です。";
			$isValidated=false;
		}else if(!preg_match("/^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}$/", $rel["start"])){
			$errorStart="開始日時の形式が正しくありません。";
			$isValidated=false;
		}

		if(!empty($rel["finish"])&&!preg_match("/^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}$/", $rel["finish"])){
			$errorFinish="終了日時の形式が正しくありません。";
			$isValidated=false;
		}

		if(empty($rel["place"])){
			$errorPlace="場所が未入力です。";
			$isValidated=false;
		}

		if($isValidated==true){
			try{
				$pdo=db_init();
				$stmt=$pdo->prepare("UPDATE events SET title=?,start=?,end=?,place=?,group_id=?,detail=? WHERE id=?");
				$stmt->execute(array($rel["name"],$rel["start"],$rel["finish"],$rel["place"],$rel["group"],$rel["message"],$rel["eventid"]));

				header("Location:PG_09.php");

			}catch(PDOException $e){
				$e->getMessage();
				exit;
			}
		}
	}



?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Event Manager｜イベント編集</title>
	<script src="js/jquery-2.2.3.js"></script>
	<link href="style.css" rel="stylesheet">

	<script>
	<?php require_once 'jqheader.php';?>
	</script>

</head>

<body>
<div id="container">
	<?php require_once 'header.php';?>

	<h1>イベント編集</h1>

	<form action="" method="post">
	<p>タイトル(必須)</p>
	<?php if(isset($errorName)) echo '<p class="error">'.$errorName.'</p>';?>
	<input type="text" name="name" value="<?php echo $rel["name"]?>">
	<p>開始日時(必須)</p>
	<?php if(isset($errorStart)) echo '<p class="error">'.$errorStart.'</p>';?>
	<input type="text" name="start" value="<?php echo $rel["start"]?>" placeholder="0000-00-00 00:00:00">
	<p>終了日時</p>
	<?php if(isset($errorFinish)) echo '<p class="error">'.$errorFinish.'</p>';?>
	<input type="text" name="finish" value="<?php echo $rel["finish"]?>" placeholder="0000-00-00 00:00:00">
	<p>場所(必須)</p>
	<?php if(isset($errorPlace)) echo '<p class="error">'.$errorPlace.'</p>';?>
	<input type="text" name="place" value="<?php echo $rel["place"]?>">
	<p>対象グループ</p>
	<select name="group">
		<?php foreach ($groups as $group){ ?>
			<option value="<?php echo $group["id"]?>" <?php if($rel["group"]==$group["id"]) echo "selected"?>><?php echo $group["name"]?></option>
		<?php } ?>
	</select>
	<p>詳細</p>
	<textarea rows="7" name="message"><?php echo $rel["message"];?></textarea>
	<input type="hidden" name="eventid" value=<?php echo $rel["eventid"]; ?>>

	<input type="submit" name="cancel" value="キャンセル" class="white_button">
	<input type="submit" name="save" value="保存" class="red_button">
	</form>
</div>
</body>
</html>