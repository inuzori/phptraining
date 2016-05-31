<?php
	session_start();

	//if(!isset($_SESSION["login"])){
	//	header("Location:PG_01.php");
	//}
	$header=1;
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

		a:link { color:white; }
		a:visited { color:white; }
		a:hover { color:white; }
		a:active { color:white; }

		.logout{
			text-decoration:none;
		}

		.logout:link { color:black; }
		.logout:visited { color:black; }
		.logout:hover { color:black; }
		.logout:active { color:black; }

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
			margin:10px 0px;
			font-size:20px;
			height:30px;
			padding-left:10px;
		}
	</style>

</head>

<body>
	<div id=container>
		<header>
		<ul id="menu" style="list-style:none;">
			<li style="width:300px; font-size:18px; font-family:Comic sans MS; font-weight:bold;">Event Manager</li>
			<li style="width:150px;"></li>
			<li style="width:150px;"></li>
			<li style="width:150px;"></li>
			<li style="width:150px;"></li>
			<li style="width:150px;"></li>
		</ul>
		</header>
	</div>
</body>
</html>