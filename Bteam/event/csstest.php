<?php
session_start();

//if(!isset($_SESSION["login"])){
//	header("Location:PG_01.php");
//}
$header=1;

$page=1;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Event Manager</title>
	<script src="js/jquery-2.2.3.js"></script>

	<style>
		body{
			font-family:"メイリオ";
		}

		a{
			text-decoration:none;
		}

		ul a,.orange_button,.red_button,.nightingale_button,.black_button:link { color:white; }
		ul a,.orange_button,.red_button,.nightingale_button,.black_button:visited { color:white; }
		ul a,.orange_button,.red_button,.nightingale_button,.black_button:hover { color:white; }
		ul a,.orange_button,.red_button,.nightingale_button,.black_button:active { color:white; }

		.logout,.white_button{
			text-decoration:none;
		}

		.logout,.white_button:link { color:black; }
		.logout,.white_button:visited { color:black; }
		.logout,.white_button:hover { color:black; }
		.logout,.white_button:active { color:black; }

		body,p,h1,li,ul{
			padding:0px;
			margin:0px;
		}

		li{
			float:left;
			padding: 15px 0px;
		}

		body{
			margin:0px auto;
			width:1000px;
			background-color:#eee;
		}

		#container{
			margin:0px auto;
			width:1000px;
		}

		header{
			background-color:#EDD634;
			border-radius:5px;
			overflow:hidden;
			width:1000px;
			color:white;
			text-align:center;
		}

		header p{
			clear:both;
			overflow:hidden;
			background-color:white;
			border:solid 1px black;
			color:black;
			margin-left:850px;
			width:148px;
			margin-right:0px;
			border-radius:5px;
			visibility:hidden;
		 }
		.child{
			clear:both;
			background-color:#eee;
		}

		.login_button{
			margin:10px 0px;
			border-radius:5px;
			padding:5px 0px;
			font-size:16px;
			font-family:"メイリオ";
			font-weight:bold;
			color:white;
			background-color:orange;
			width:1000px;
			border-style:none;
		}

		input[type="text"]{
			width:988px;
			border-radius:5px;
			border:solid 1px black;
			margin:5px 0px 10px 0px;
			font-size:20px;
			height:30px;
			padding-left:10px;
		}

		form textarea{
			width:988px;
			border-radius:5px;
			border:solid 1px black;
			margin:5px 0px 10px 0px;
			font-size:20px;
			font-family:"メイリオ";
			padding-left:10px;
		}
		.join{
			border-radius:5px;
			padding:5px;
			font-size:12px;
			font-family:"メイリオ";
			font-weight:bold;
			color:white;
			background-color:orange;
			border-style:none;
			width:30px;
			text-align:center;
		}


		.back,.orange_button{
			margin:10px 0px;
			border-radius:5px;
			padding:5px 15px;
			font-size:16px;
			font-family:"メイリオ";
			font-weight:bold;
			color:white;
			background-color:orange;
			border-style:none;
		}

		.save,.save,.Registration,.red_button{
			margin:10px 0px;
			border-radius:5px;
			padding:5px 15px;
			font-size:16px;
			font-family:"メイリオ";
			font-weight:bold;
			color:white;
			background-color:red;
			border-style:none;
		}

		.cancel,.white_button{
			margin:10px 0px;
			border-radius:5px;
			padding:5px 15px;
			font-size:16px;
			font-family:"メイリオ";
			font-weight:bold;
			color:#000;
			background-color:white;
			border:1px black solid;
		}

		.delete,.black_button{
			margin:10px 0px;
			border-radius:5px;
			padding:5px 15px;
			font-size:16px;
			font-family:"メイリオ";
			font-weight:bold;
			color:white;
			background-color:black;
			border-style:none;
		}

		form p{
			font-weight:bold;
		}

		.nightingale_button{
			margin:10px 0px;
			border-radius:5px;
			padding:5px 15px;
			font-size:16px;
			font-family:"メイリオ";
			font-weight:bold;
			color:white;
			background-color:#EDD634;
			border-style:none;
		}



		.block{
			border-right:1px solid black;
		}

		table.table1,.table1 th,.table1 td{
			width:1000px;
			border:1px solid #EDD634;
			border-collapse:collapse;
		}

		th,td{
			padding:13px 10px;
		}

		th{
			text-align:left;
		}

		table{
			margin:15px 0px;
		}

		table.table2,.table2 th,.table2 td{
			width:1000px;
			border-width:1px 0px;
			border-color:#EDD634;
			border-style:solid;
			border-collapse:collapse;
		}

		table.pages{
			width:230px;
			margin-left:750px;
			border:1px #EDD634 solid;
			border-radius:3px;
			border-spacing:0;
			text-align:center;
		}

		.pages td{
			border-width:0px 1px;
			border-color:#EDD634;
			border-style:solid;
		}

		.pages th{
			padding-right:0px;
			padding-left:12px;
		}

		.table2 th{
			width:250px;
		}

		.now{
			background-color:orange;
			color:white;
		}
	</style>

	<script>
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
	});
	</script>
</head>

<body>
	<div id=container>
		<header>
		<ul id="menu" style="list-style:none;">
			<li style="width:300px; font-size:18px; font-family:Comic sans MS; font-weight:bold;">Event Manager</li>
			<li style="width:150px; <?php if($header==1){ echo 'background-color:orange;'; }else{ echo '" class="change'; } ?>"><a href=#>本日のイベント</a></li>
			<li style="width:150px; <?php if($header==2){ echo 'background-color:orange;'; }else{ echo '" class="change'; } ?>"><a href=#>イベント管理</a></li>
			<li style="width:150px; <?php if($header==3){ echo 'background-color:orange;'; }else{ echo '" class="change'; } ?>"><a href=#>ユーザ管理</a></li>
			<li style="width:100px;"></li>
			<li style="width:140px; padding-right:10px; text-align:right;" class="dropdown"><?php echo "山田 太郎 ▼"?></li>
		</ul>
		<div class="child">
			<p><a class="logout" href=#>ログアウト</a></p>
		</div>
		</header>


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

		<form action="" method="post">
			<p>パスワード</p>
			<p><input type="text" name="id"></p>
			<p><input type="text" name="pass"></p>
			<p><textarea rows="7"></textarea></p>
			<input class="login_button" type="submit" value="ログイン">
		</form>

		<table class="table1">
			<tr>
				<th>タイトル</th><th>場所</th><th>対象グループ</th><th>詳細</th>
			</tr>
			<tr>
				<td>タイトル</td><td>場所</td><td>対象グループ</td><td><a class="white_button" href=#>詳細</a></td>
			</tr>
			<tr>
				<td>タイトル</td><td>場所</td><td>対象グループ</td><td><a class="white_button" href=#>詳細</a></td>
			</tr>
		</table>

		<table class="table2">
			<tr>
				<th>タイトル</th><td>場所</td>
			</tr>
			<tr>
				<th>タイトル</th><td>場所</td>
			</tr>
			<tr>
				<th>タイトル</th><td>場所</td>
			</tr>
		</table>

		<a class="orange_button" href=#>一覧に戻る</a>
		<a class="red_button" href=#>テスト</a>
		<a class="white_button" href=#>テスト</a>
		<a class="black_button" href=#>テスト</a>
		<a class="nightingale_button" href=#>テスト</a>
	</div>
</body>
</html>