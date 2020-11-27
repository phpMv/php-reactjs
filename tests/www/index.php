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
	include 'include/' . $inc . '.php';
} else {
	echo "Hello React !";
}
?>
</body>

</html>