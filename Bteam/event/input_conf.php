<?php
$sub = 'submit_test';
$query = 'jquery';
var_dump($_POST);
// 「送信」ボタンが押された場合の処理
if (isset($_POST["token"])&&
	isset($_POST["send"])) {
  	  echo "sumit send ok";
  }
// 「修正」ボタンが押された場合の処理
if (isset($_POST["back"])) {
	echo "sumit back ok";
}
?>
<html>
<meta charset="utf-8" />
<script src="../libs/jquery-2.2.3.min.js"></script>
<script>
$(document).ready(function () {
	$('#form').submit(function(){
		$('<input>').attr({
		    type: 'submit',
		    name: 'send',
		}).appendTo('#form');
		$('h1').css('background-color','#ccc');
		//（おまけ）jqueryでのpost,get値の取得方法
		var formData = $('#form').serialize();
//		alert(formData);
	})
});
</script>
<body>
<h1>確認画面</h1>
<p>件名：<?php echo $sub; ?></p>
<p>内容：<?php echo $query; ?></p>
<form id="form" action="" method="post" style="display:inline">
  <input type="hidden" name="token" value="token1245" />
  <input type="submit" name="send" value="送信" />
</form>
<form id="form1" action="" method="post" style="display:inline">
  <input type="submit" name="back" value="修正" />
</form>
</body>
</html>
