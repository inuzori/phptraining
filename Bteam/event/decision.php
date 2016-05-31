<form style="width:500px; display:inline;"action="" method="POST">
<?php
if ($types["name"]=="一般ユーザー"){
		if ($types["name1"]==$names){
			foreach ($attend_users as $bocci1){
				if ($bocci1["user_id"]==$id1){
					$flg=1;
					break;
				}
			}
			if ($flg=="1"){
				echo   '<input type="submit" class="nightingale_button" name="delete" value="参加取り消し">
								<input type="submit" class="white_button" name="edit" value="編集"></form>
								<button id="button" class="black_button">削除</button>';
				$_SESSION["button_flg"]=1;
			}else {
				echo   '<input type="submit" class="nightingale_button" name="join"  value="参加">
								<input type="submit" class="white_button" name="edit" value="編集"></form>
								<button id="button" class="black_button">削除</button>';
				$_SESSION["button_flg"]=0;
			}
		}else {
			foreach ($attend_users as $bocci1){
				if ($bocci1["user_id"]==$id1){
					$flg=1;
					break;
				}
			}
			if ($flg=="1"){
				echo   '<input type="submit" class="nightingale_button" name="delete" value="参加取り消し"></form>';
				$_SESSION["button_flg"]=1;
			}else {
				echo   '<input type="submit" class="nightingale_button" name="join" value="参加"></form>';
				$_SESSION["button_flg"]=0;
			}
		}
}
if ($types["name"]=="管理ユーザー"){
	foreach ($attend_users as $bocci1){
		if ($bocci1["user_id"]==$id1){
			$flg=1;
			break;
		}
	}
	if ($flg=="1"){
		echo   '<input type="submit" class="nightingale_button" name="delete" value="参加取り消し">
								<input type="submit" class="white_button" name="edit" value="編集"></form>
								<button id="button" class="black_button">削除</button>';
		$_SESSION["button_flg"]=1;

	}else {
		echo   '<input type="submit" class="nightingale_button" name="join" value="参加">
								<input type="submit" class="white_button" name="edit" value="編集"></form>
								<button id="button" class="black_button">削除</button>';
		$_SESSION["button_flg"]=0;

	}
}
?>