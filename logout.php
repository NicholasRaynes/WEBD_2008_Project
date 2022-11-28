<?php
	session_start();

	$_SESSION = [];
?>

<!DOCTYPE html>
<html lange="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title>Success!</title>
</head>
<body>
	<div class="text-center">
		<h1 id="success_message">You have successfully logged out!</h1>
		<button id="home" type="button" class="btn btn-primary" onclick="location.href='index.php'">Home</button>
	</div>
</body>
</html>