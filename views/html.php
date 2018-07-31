<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?=$title?></title>
		<meta charset="us-ascii">
		<link rel="stylesheet" href="./css/bootstrap.min.css" />
		<link rel="stylesheet" href="./css/bootstrap-theme.css" />
		<link rel="stylesheet" href="./css/style.css" />
		<script src="./js/script.js"></script>
	</head>
	<body>
<?php if($userSession){ ?>
		<div>
			<a class="btn btn-link" href='./?section=Words'>Words</a>
			<a class="btn btn-link" href="./?section=Tags">Tags</a>
			<a class="btn btn-link" href="./?section=Test">Test</a>
			<span><form method="post">Hello <?=$userSession['name']?> <button class="btn btn-warning btn-sm" name="logout" value="1">Logout</button></form></span>
		</div>
<?php } ?>
<?php include($view); ?>
	</body>
</html>
