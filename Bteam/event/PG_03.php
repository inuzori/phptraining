<?php
session_start();
require_once "db.inc.php";
require_once "auth.inc.php";

auth_confirm();

$header=1;

$id1=$_SESSION["userid"];

//ログイン情報のセッション
define("NUM_PER_PAGE", 5);
$date=date('Y-m-d');

try {
	//データベース準備
	$pdo = db_init();




	// 実件数の取得
	$sql ="SELECT COUNT(*) AS hits FROM events
			WHERE start LIKE '%{$date}%'";
	$stmt = $pdo->query($sql);
	$res = $stmt->fetch();
	$hits = $res["hits"];

	$sql = "SELECT * FROM attends WHERE {$id1}=user_id";
	$stmt = $pdo->query($sql);
	$attend = $stmt->fetchAll();



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
	$sql = "SELECT *
			  FROM events JOIN groups ON events.group_id = groups.id
			  WHERE start LIKE '%{$date}%'
	ORDER BY start DESC LIMIT {$offset},".NUM_PER_PAGE;


	$stmt = $pdo->query($sql);
	$events = $stmt->fetchAll();

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
<title>Event Manager｜本日のイベント</title>
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

<h1>本日のイベント</h1>
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
        echo '<a href="?p='.$prevPage.'">&#8810;</a> ';
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
          echo '<td class="notnow"><a href="?p='.$p.'">'.$p.'</a></p>';
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
        echo ' <a href="?p='.$nextPage.'">&#8811;</a>';
      }
      echo "</th>";
    }
    ?></tr>
      </table>

      <?php
if (!empty($events)){
	?>
<table class="table1">
	<tr>
		<th>タイトル</th>
		<th>開始日時</th>
		<th>場所</th>
		<th>対象グループ</th>
		<th>詳細</th>
	</tr>

	  <tr>
   <?php if(empty($events)) $sanka=NULL;?>
  <?php foreach ($events as $event):?>
  	<?php   $weekday = array( "日", "月", "火", "水", "木", "金", "土" );
  $stats=new DateTime($event["start"]);
  $s=$weekday[$stats->format('w')];?>
  <?php if(empty($attend)) $sanka=NULL;?>
  <?php foreach ($attend as $user_id):?>
	<?php
		  if ($user_id["event_id"]==$event[0]){
		  	$sanka='<span class="join">参加</span>';
		  	break;
		  }
		  else {
		  	$sanka=NULL;
		  }
	?>
	<?php endforeach;?>
		<td><?php echo $event["title"].$sanka;?></td>
		<td><?php echo $stats->format('Y年n月j日')."({$s})".$stats->format('H時i分');?></td>
		<td><?php echo $event["place"];?></td>
		<td><?php echo $event["name"];?></td>
		<td><a class="white_button" href="PG_05.php?id=<?php echo $event[0]; ?>">詳細</a></td>
	</tr>
	<?php endforeach;?>
</table>
<?php } ?>
<?php if (empty($events)){
echo "<h1>本日のイベントはありません。<br />
		あなたもイベントを企画してみませんか？
		</h1>";
echo '<a class="red_button" href="PG_06.php">イベントの登録</a>';

}?>
</div>
</body>
</html>