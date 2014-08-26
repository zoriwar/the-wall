<?php

session_start();
include('include/connection.php');
if (isset($_SESSION['first-name']) && $_SESSION['logged-in']) {
	$welcome_str = "Welcome " . $_SESSION['first-name'] ;
} else {
	$welcome_str = "";
}


?>
<html>
<head>
	<title>Wall Assignment</title>
	<style type="text/css">
		input[type="submit"]{
			background-color: blue;
			border: 2px solid blue;
			color: white;
			font-weight: bold;
			display: block;
			margin-left:600px;
			border-radius: 20px;
		}
		textarea{
			width: 700px;
			height: 120px;
		}

		#comment {
			margin: 0px 0px 0px 300px;
			width: 400px;
			height: 40px;
		}
		#header{
			background-color: black;
			color: white;
			padding-left: 200px;
			height: 100px;
			width: 960px;
		}
		a{
			color: white;
			font-weight: bold;
			padding-left: 200px;
		}
		img{
			padding: 10px 400px 10px 40px;
			height: 70px;
		}
		#credentials{
			display: inline-block;
			width: 280px;
			background-color: green;
		}
		#messages-section{
			width: 960px;
			padding-left: 200px;
			background-color: silver;
		}
	</style>
</head>
<body>
	<div id="header">
		<img src="coding_dojo_logo.png" alt="">
		<div id="credentials">
			<!-- <form action='login.php' method='post'>
				<input type='text' name='email' placeholder='email'>
				<input type='password' name='password' placeholder="password">
				<button type='submit' name='submit'>Login</button>
			</form> -->
			<?= $welcome_str ?>
			<a href="registration.php">Register</a>
		</div>
	</div>
	<div id="messages-section">
		<h2>Post a message</h2>
		<form action="process.php" method="post">
			<textarea name="message" id="message"></textarea>
			<input type='hidden' name='action' value='post'>
			<input type="submit" value="Post a message">
		</form>
		<?php
			$sql = "SELECT * FROM messages ORDER BY updated_at DESC";
			$all_messages = fetchrecords($sql);
			foreach ($all_messages as $record) {
				$sql_comments = "SELECT * FROM comments WHERE {$record['idmessages']} = comments.messages_idmessages";
				$comment_arr = fetchrecords($sql_comments);
				$author_id = $record['users_id'];
				$author_query = "SELECT DISTINCT concat(first_name, ' ', last_name ) AS name
								FROM users WHERE {$author_id} = id";
				$author_name = fetchrecords($author_query);

				// var_dump($author_name);
				// var_dump($comment_arr);
				// echo $record['first_name'] . " " . $record['last_name'] . " " . date();
				
				// <<< this is where message author goes >>>
				echo $author_name[0]['name'] . " " . date('F d Y', strtotime($record['updated_at'])) . "<br>";
				echo $record['message'] . "<br>"; 
				foreach ($comment_arr as $value) {
					echo $value['comment'];
				}
				// echo $comment_arr['comment'] . "<br>"; ?>
				<!-- <<<where the comments go>>>	 -->
				<h2>Post a comment</h2>
					<form action="process.php" method="post">
						<textarea name="comment" id="comment"></textarea>
						<input type='hidden' name='comment_act' value= "<?= $record['idmessages'] ?>" >
						<input type="submit" value="Post a comment">
					</form>
<?php			} ?>
	</div>
</body>
</html>