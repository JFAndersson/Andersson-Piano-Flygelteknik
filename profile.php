<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Andersson Group - Profil</title>
		<link rel="stylesheet" href="css/memberpage.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Andersson Group</h1>
				<a href="home.php"><i class="fas fa-home"></i>Hem</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logga ut</a>
			</div>
		</nav>
		<div class="content">
			<h2>Kontouppgifter</h2>
			<div class="textBox">
				<p id="detailsHeader">Nedan hittar du dina kontouppgifter:</p>
				<table>
					<tr>
						<td>Användarnamn:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Lösenord:</td>
						<td><?=$password?></td>
					</tr>
					<tr>
						<td>E-post:</td>
						<td><?=$email?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>