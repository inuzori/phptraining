<?php
session_start();

//if(!isset($_SESSION["login"])){
//	header("Location:PG_01.php");
//}
$header=1;

$page=1;

$id=26;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Event Manager</title>
	<script src="js/jquery-2.2.3.js"></script>
	　<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
　<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/start/jquery-ui.css" rel="stylesheet">
　<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>

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

	<script>
	var eventid= <?php echo $id;?>;
	var flg=0;

	$(function(){
		$(".change,.dropdown").hover(function(){
			$(this).css("background-color","#FFCC66");
		},
		function(){
			$(this).css("background-color","#EDD634");
		});

		$(".dropdown").click(function(){
			if($(".child>p").css("visibility")=="hidden"){
				$(".child>p").css("visibility","visible");
			}else{
				$(".child>p").css("visibility","hidden");
			}
		});

		$(".notnow").hover(function(){
			$(this).css("background-color","#FFCC66");
		},
		function(){
			$(this).css("background-color","#eee");
		});

		$("#button").on("click", function () {
			$(".alert").dialog({
				modal: true,
				width: 500,
				height:150,
				buttons: [
					{	text:"Cancel",
						class:"dialog_cancel",
						click:function(){
							$(this).dialog("close");
						}
					},
					{	text:"OK",
						class:"dialog_ok",
						click:function(){
							$.post("FN_10.php",{id:eventid},function(data,textStatus) {
								if(textStatus == 'success'){
									window.location.href="PG_11.php";
								}
							}
							,'json');


						}
					}
				]
			});
		});
	});
	</script>

	<link href="style.css" rel="stylesheet">
</head>

<body>
	<div id=container>
		<?php require_once 'header.php';?>


		<table class="pages">
			<tr>
			<th class="notnow">&#8810;</th>
			<td class="notnow">1</td>
			<td class="now">2</td>
			<td class="notnow">3</td>
			<th class="notnow">&#8811;</th>
			</tr>
		</table>

		<h1>イベント削除</h1>
		<p>イベントの削除が完了しました。</p><div class="join">完了</div>
		<a href=#>イベント一覧に戻る</a>

		<div class="alert" style="display:none;">
			<p style='font-family:"MingLiU-ExtB","HG教科書体";'>本当に削除してよろしいですか？</p>
		</div>


		<button id="button" class="white_button">削除</button>


	</div>
</body>
</html>