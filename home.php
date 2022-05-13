<?php
// Använder sessions för att bekräfta om användaren har loggat in
session_start();
// Är användaren inte inloggad skickas hen till hemskärmen
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Andersson Group - Hem</title>
		<link rel="stylesheet" href="css/memberpage.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Andersson Group</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profil</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logga ut</a>
			</div>
		</nav>
		<div class="content">
			<h2>Hem</h2>
			<p class="textBox">Välkommen tillbaka, <?=$_SESSION['name']?>!</p>
		</div>
	</body>
</html>