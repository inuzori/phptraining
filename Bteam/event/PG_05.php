<?php
session_start();
//$id1自分のID
$id1=$_SESSION["userid"];
$flg=0;
$header=2;

$button_flg=0;

require_once "db.inc.php";
require_once "auth.inc.php";

//--------------------
// ログイン認証済みでなければログインページへ移動
//--------------------
auth_confirm();

//もしid取れてなかったら帰りなさい!
 if (empty($_GET["id"])) {
 	header("Location: PG_04.php");
	exit;
}

$id = $_GET["id"];

try {
		//データベース準備
		$pdo = db_init();


		//ボタン運動
		if($_SERVER["REQUEST_METHOD"]==="POST"){
			if(isset($_POST["join"])&&(isset($_SESSION["button_flg"])&&$_SESSION["button_flg"]==0)){
				$_SESSION["button_flg"]=1;
				//不参加時の参加申し込み
				$sql="INSERT INTO attends VALUES(NULL,?,?)";
				$stmt = $pdo->prepare($sql);
				$stmt->execute(array($id1,$id));
			}
		}
		if(isset($_POST["delete"])&&(isset($_SESSION["button_flg"])&&$_SESSION["button_flg"]==1)){
			$_SESSION["button_flg"]=0;
			$sql="DELETE FROM attends WHERE user_id=? and event_id=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array($id1,$id));
		}
		if(isset($_POST["edit"])){
			header("Location:PG_08.php?id=".$id);
		}



	//JOIN[events-attends-users-groups] ASusers.nameをnamesに
	//イベントの基本的な情報の取得
		$sql = "SELECT *,users.name AS names FROM
				events JOIN attends ON events.id
				JOIN  users ON events.registered_by=users.id
				JOIN groups ON events.group_id=groups.id
				WHERE events.id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($id));
		$events = $stmt->fetch();

	//JOIN[attends-usera]
	//参加者の取得
	//=?取得したイベントidが入る
		$sql = "SELECT *FROM attends JOIN users
				ON attends.user_id=users.id
				WHERE attends.event_id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($id));
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

		//一般ユーザーかどうかのSQLを書くための
		//一般ユーザーと管理者ユーザーの取得

	$sql="SELECT * ,users.name AS name1 FROM users JOIN user_types
			 ON users.type_id=user_types.id WHERE users.id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($id1));
		$types= $stmt->fetch();


	$sql="SELECT * FROM attends WHERE event_id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($id));
		$attend_users= $stmt->fetchAll();


		if ($events == FALSE) {
			header("Location: PG_04.php");
			exit;
		}


		$title = $events["title"];
		$start = $events["start"];
		$end  = $events["end"];
		$place = $events["place"];
		$group_id = $events["name"];
		$detail = $events["detail"];
		$names = $events["names"];
		$created = $events["name"];
		// 実件数の取得

		$weekday = array( "日", "月", "火", "水", "木", "金", "土" );
		$stats=new DateTime($start);
		$s=$weekday[$stats->format('w')];
		$ends=new DateTime($end);
		$e=$weekday[$ends->format('w')];


}
catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>Event Manager｜イベント詳細</title>
	<script src="js/jquery-2.2.3.js"></script>
	　<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
　<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/start/jquery-ui.css" rel="stylesheet">
　<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<link href="style.css" rel="stylesheet">

<script>
var eventid= <?php echo $id;?>;
<?php require_once 'jqheader.php';?>
</script>

<style>
		.dialog_cancel{
			font-family:"MingLiU-ExtB","HG教科書体" !important;
			background: #FFF !important;
			border: 1px solid #dcdddd !important;
			border-radius: 4px !important;
			-moz-border-radius: 4px !important
			-webkit-border-radius: 4px !important;
			color: #111 !important;
			padding: 2px 5px !important;
			width:80px !important;
			height:25px !important;
			font-size:11px !important;
		}

		.dialog_ok{
			font-family:"MingLiU-ExtB","HG教科書体" !important;
			background: #d3381c !important;
			border: 1px solid #dcdddd !important;
			border-radius: 4px !important;
			-moz-border-radius: 4px !important;
			-webkit-border-radius: 4px !important;
			color: #FFF !important;
			padding: 2px 5px !important;
			width:80px !important;
			height:25px !important;
			font-size:11px !important;
		}

		.ui-dialog-titlebar {
			display: none;
		}

		.ui-widget-overlay {
   			 background: #333;
    		 opacity: .80;
		}

</style>
</head>
<body>


<body>
  <div id="container">
    <?php require_once "header.php"; ?>
  <h1>イベント詳細</h1>
  	<table class="table2" border="1">
		<tr>
			<th>タイトル</th>
			<td><?php echo $title;?></td>
		</tr>
		<tr>
			<th>開始日時</th>
			<td><?php echo $stats->format('Y年n月j日')."({$s})".$stats->format('H時i分');?></td>
		</tr>
		<tr>
			<th>終了日時</th>
			<td><?php echo $ends->format('Y年n月j日')."({$e})".$ends->format('H時i分');?></td>
		</tr>
		<tr>
			<th>場所</th>
			<td><?php echo $place;?></td>
		</tr>
		<tr>
			<th>対象グループ</th>
			<td><?php echo $group_id;?></td>
		</tr>
		<tr>
			<th>詳細</th>
			<td><?php echo nl2br($detail);?></td>
		</tr>
		<tr>
			<th>登録者</th>
			<td><?php echo $names;?></td>
		</tr>
		<tr>
			<th>参加者</th>

			<td>
			<?php foreach ($users as $minna) :?>
			<?php echo $minna["name"];?>
			<?php endforeach;?>
			</td>
		</tr>
  	</table>
<a class="orange_button" href="PG_04.php" >一覧に戻る</a>
<?php require_once "decision.php";?>

<div class="alert" style="display:none;">
	<p style='font-family:"MingLiU-ExtB","HG教科書体";'>本当に削除してよろしいですか？</p>
</div>
</div>
</body>
</html>
