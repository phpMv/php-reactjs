<?php
include '/c3.php';
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
define('MY_APP_STARTED', true);

require ROOT . 'vendor/autoload.php';
if (\strpos($_GET['c'] ?? '', 'c3') === false) {
	?>
	<!doctype html>
	<html>
	<head>
		<meta charset='UTF-8'>
		<title>React tests</title>
		<script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
		<script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>
	</head>
	<body>
	<div id='react'>
	</div>
	<?php
	$inc = $_GET['c'] ?? '';
	if ($inc != '') {
		include ROOT . 'include/' . $inc . '.php';
	} else {
		echo "Hello React !";
	}
	?>
	</body>

	</html>
	<?php
}