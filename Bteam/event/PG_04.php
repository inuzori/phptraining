<?php
session_start();

require_once "db.inc.php";
require_once "auth.inc.php";

auth_confirm();

$header=2;
$id1=$_SESSION["userid"];
$nowpage=0;
$display=false;
$phrase="DESC";

//ログイン情報のセッション
define("NUM_PER_PAGE", 4);


try {

	if($_SERVER["REQUEST_METHOD"]==="POST"){
		if(isset($_POST["event_join"])){
			$pflg=true;
			$count=0;
		}
		if(isset($_POST["event_notjoin"])){
			$pflg=false;
			$count=0;
		}
		if(isset($_POST["desc"])){
			$phrase="DESC";
		}
		if(isset($_POST["asc"])){
			$phrase="ASC";
		}
	}else if($_SERVER["REQUEST_METHOD"]==="GET"){
		if(isset($_GET["pflg"])){
			$pflg=(boolean)$_GET["pflg"];
			$count=0;
		}
		if(isset($_GET["phrase"])){
			$phrase=$_GET["phrase"];
		}
	}

	//データベース準備
	$pdo = db_init();

	if(!isset($pflg)){
		// 実件数の取得
		$sql = "SELECT COUNT(*) AS hits FROM events";
		$stmt = $pdo->query($sql);
		$res = $stmt->fetch();
		$hits = $res["hits"];

	//自分のログインIDとattendのuser_idが
	//同じだったものを取得
		$sql = "SELECT * FROM attends WHERE {$id1}=user_id";
		$stmt = $pdo->query($sql);
		$attend = $stmt->fetchAll(PDO::FETCH_ASSOC);


	//ceil(小数点きり上げ)
	//ページ数の計算
		$numPages = ceil($hits / NUM_PER_PAGE);

		//ページ番号の取得
		if (isset($_GET["p"])) {
			$currentPage = $_GET["p"];
		}
		else {
			$currentPage = 1;
		}
		$prevPage = $currentPage - 1;
		$nextPage = $currentPage + 1;

	//LIMITオプション生成
		$offset = ($currentPage - 1) * NUM_PER_PAGE;
	//データ取得(JOINで結合済み)
		$sql = "SELECT *,events.id AS ids
				  FROM events JOIN groups ON events.group_id = groups.id
				  ORDER BY start ".$phrase." LIMIT {$offset},".NUM_PER_PAGE;
		$stmt = $pdo->query($sql);
		$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}else if($pflg==true){
		$sql = "SELECT COUNT(*) AS hits FROM attends WHERE user_id={$id1}";
		$stmt = $pdo->query($sql);
		$res = $stmt->fetch();
		$hits = $res["hits"];

		//自分のログインIDとattendのuser_idが
		//同じだったものを取得
		$sql = "SELECT * FROM attends WHERE {$id1}=user_id";
		$stmt = $pdo->query($sql);
		$attend = $stmt->fetchAll(PDO::FETCH_ASSOC);


		//ceil(小数点きり上げ)
		//ページ数の計算
		$numPages = ceil($hits / NUM_PER_PAGE);

		//ページ番号の取得
		if (isset($_GET["p"])) {
			$currentPage = $_GET["p"];
		}
		else {
			$currentPage = 1;
		}
		$prevPage = $currentPage - 1;
		$nextPage = $currentPage + 1;

		//LIMITオプション生成
		$offset = ($currentPage - 1) * NUM_PER_PAGE;
		//データ取得(JOINで結合済み)
		$sql = "SELECT *,events.id AS ids
		FROM events JOIN groups ON events.group_id = groups.id
		ORDER BY start ".$phrase;
		$stmt = $pdo->query($sql);
		$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

	}else if($pflg==false){
		$sql = "SELECT COUNT(*) AS hits FROM events";
		$stmt = $pdo->query($sql);
		$res = $stmt->fetch();
		$hits = $res["hits"];

		$sql = $sql = "SELECT COUNT(*) AS hits FROM attends WHERE user_id={$id1}";
		$stmt = $pdo->query($sql);
		$res = $stmt->fetch();
		$nothits = $res["hits"];

		//自分のログインIDとattendのuser_idが
		//同じだったものを取得
		$sql = "SELECT * FROM attends WHERE {$id1}=user_id";
		$stmt = $pdo->query($sql);
		$attend = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$hits=$hits-$nothits;

		//ceil(小数点きり上げ)
		//ページ数の計算
		$numPages = ceil($hits / NUM_PER_PAGE);

		//ページ番号の取得
		if (isset($_GET["p"])) {
			$currentPage = $_GET["p"];
		}
		else {
			$currentPage = 1;
		}
		$prevPage = $currentPage - 1;
		$nextPage = $currentPage + 1;

		//LIMITオプション生成
		$offset = ($currentPage - 1) * NUM_PER_PAGE;
		//データ取得(JOINで結合済み)
		$sql = "SELECT *,events.id AS ids
		FROM events JOIN groups ON events.group_id = groups.id
		ORDER BY start ".$phrase;
		$stmt = $pdo->query($sql);
		$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


}catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>Event Manager｜イベント一覧</title>
<script type="text/javascript" src="js/jquery-2.2.3.js"></script>
<link href="style.css" rel="stylesheet">
<script>
<?php
require_once "jqheader.php";
?>
</script>
</head>
<body>
<div id="contener">
<?php require_once "header.php"; ?>

<h1>イベント一覧</h1>
      <table class="pages">
      <tr>
    <?php
    if ($numPages >= 1) {
      //--------------------
      // 前のページへのリンク
      //--------------------
      echo '<th class="notnow">';
      if ($currentPage == 1) {
        echo "&#8810;";
      }
      else {
        echo '<a href="?p='.$prevPage;
        if(isset($phrase)){
        	echo '&phrase='.$phrase;
        }

        if(isset($pflg)&&$pflg==true){
        	echo '&pflg=true';
        }else if(isset($pflg)&&$pflg==false){
        	echo '&pflg=0';
        }
        echo '">&#8810;</a></p>';
      }

      echo "</th>";
      //--------------------
      // ページ番号のリンク
      //--------------------
      for ($p = 1; $p <= $numPages; $p++) {
        if ($p == $currentPage) {
          echo '<td class="now">'.$p.'</td>' ;
        }
      else {
          echo '<td class="notnow"><a href="?p='.$p;
	      if(isset($phrase)){
	        	echo '&phrase='.$phrase;
	        }

	        if(isset($pflg)&&$pflg==true){
	        	echo '&pflg=true';
	        }else if(isset($pflg)&&$pflg==false){
	        	echo '&pflg=0';
	        }
	        echo '">'.$p.'</a></p>';
	      }
      }
      }
      //--------------------
      // 次のページへのリンク
      //--------------------
      echo '<th class="notnow">';
      if ($currentPage == $numPages) {
        echo "&#8811;";
      }
      else {
        echo ' <a href="?p='.$nextPage;
      if(isset($phrase)){
        	echo '&phrase='.$phrase;
        }

        if(isset($pflg)&&$pflg==true){
        	echo '&pflg=true';
        }else if(isset($pflg)&&$pflg==false){
        	echo '&pflg=0';
        }
        echo '">&#8811;</a></p>';
      echo "</th>";
    }
    ?></tr>
      </table>
<table class="table1">
<tr>
  <th>タイトル</th>
  <th>開始日時</th>
  <th>場所</th>
  <th>対象グループ</th>
  <th>詳細</th>
  </tr>

   <?php if(empty($events)) $sanka=NULL;?>
  <?php foreach ($events as $event):?>
    <?php
  $weekday = array( "日", "月", "火", "水", "木", "金", "土" );
  $stats=new DateTime($event["start"]);
  $s=$weekday[$stats->format('w')];
  ?>
  <?php if(empty($attend)) $sanka=NULL;?>
  <?php foreach ($attend as $user_id):?>
  <?php

  //attendのevent_id＝eventsのidが同じものに当てはめる(条件当てはめ)
  if ($user_id["event_id"]==$event["ids"]){
  	$sanka='<span class="join">参加</span>';
  	$display=true;
  	break;
  }
  //無いものはNULLで何も入れなくてよいぞの意味じゃ
  else {
  	$sanka=NULL;
  	$display=false;
  }
  ?>

  <?php endforeach;?>
<?php if(isset($count)&&$display==$pflg){
	$count++;
}?>
  <?php if((!isset($count)||($count>$offset||($count==1&&$offset==0)))&&(!isset($pflg)||$pflg==$display)){?>
   <tr>
   <td><?php echo $event["title"].$sanka;?></td>
   <td><?php echo $stats->format('Y年n月j日')."({$s})".$stats->format('H時i分');?></td>
   <td><?php echo $event["place"];?></td>
   <td><?php echo $event["name"];?></td>
   <td><a class="white_button" href="PG_05.php?id=<?php echo $event["ids"]; ?>">詳細</a></td>
   </tr>
   <?php $nowpage++;} ?>
   <?php if($nowpage>=NUM_PER_PAGE) break;?>
   <?php endforeach;?>
</table>
<br />
<a class="red_button" href="PG_06.php">イベントの登録</a>
<form style="display:inline;" action="PG_04.php" method="post">
	<?php if(isset($_POST["event_join"])||(isset($_GET["pflg"])&&$_GET["pflg"]==true)){?>
		<input type="hidden" name="event_join" value="on">
		<?php }else if(isset($_POST["event_notjoin"])||(isset($_GET["pflg"])&&$_GET["pflg"]==0)){?>
		<input type="hidden" name="event_notjoin" value="on">
		<?php }?>
	<input type="submit" class="orange_button" value="降順" name="desc" />
	<input type="submit" class="orange_button" value="昇順" name="asc" />
</form>
<form style="display:inline;" action="PG_04.php" method="post">
	<input class="nightingale_button" type="submit" value="全てのイベント">
	<input class="nightingale_button" type="submit" name="event_join" value="参加イベント">
	<input class="nightingale_button" type="submit" name="event_notjoin" value="参加してないイベント">
</form>
</div>
</body>
</html>