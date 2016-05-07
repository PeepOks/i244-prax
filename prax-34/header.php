<html>
	<head>
		<title>Ladu</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	</head>
	<body>
	<ul id="menu">
		<li><a href="?">Pealeht</a></li>
		<?php if(isset($_SESSION['user'])): ?>
			<li><a href="?page=kuva">Kuva Ladu</a></li>
			<li><a href="?page=lisa">Lisa Lattu</a></li>
		<?php else: ?>
			<li><a href="?page=kuva">Kuva Ladu</a></li>
		<?php endif; ?>
	</ul>