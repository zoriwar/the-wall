<?php

session_start();
require('include/connection.php');


if (isset($_POST['action'])) {
	$query = "INSERT INTO messages (message, created_at, updated_at, users_id) VALUES ('{$_POST['message']}', NOW(), NOW(), '{$_SESSION['user-id']}' )";
	runQuery($query);
	header ('Location: index.php');
}


if (isset($_POST['comment'])) {
	$query = "INSERT INTO comments (messages_idmessages, comment, created_at, updated_at, users_id) VALUES ('{$_POST['comment_act']}',
		'{$_POST['comment']}', NOW(), NOW(), '{$_SESSION['user-id']}' )";

	runQuery($query);
	header ('Location: index.php');
}


?>