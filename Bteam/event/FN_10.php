<?php
	require_once 'db.inc.php';

	$pdo=db_init();
	$id=$_POST["id"];
	$stmt=$pdo->prepare("DELETE FROM events WHERE id=?");
	$stmt->execute(array($id));

	$stmt=$pdo->prepare("DELETE FROM attends WHERE event_id=?");
	$stmt->execute(array($id));

	$json['id'] = "1";
	echo json_encode($json);

	$pdo=null;
?>
