<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Kunde inte ansluta till SQL databasen: ' . mysqli_connect_error());
}

// Kollar ifall e-post och aktiveringskod existerar
if (isset($_GET['email'], $_GET['code'])) {
    
	if ($stmt = $con->prepare('SELECT * FROM accounts WHERE email = ? AND activation_code = ?')) {
		$stmt->bind_param('ss', $_GET['email'], $_GET['code']);
		$stmt->execute();

		// Lagrar resultatet så man kan kolla ifall kontot existerar i databasen
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			// Kontot existerar med den rätta e-post addressen och aktiveringskod
			if ($stmt = $con->prepare('UPDATE accounts SET activation_code = ? WHERE email = ? AND activation_code = ?')) {

				// Sätter värdet för aktiveringskoden till "activated". Det här är hur man sedan kan se ifall användaren har aktiverat sitt konto
				$newcode = 'activated';
				$stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
				$stmt->execute();
				echo 'Ditt konto är nu aktiverat! Du kan nu <a href="login.html">logga in</a>!';
			}
		} else {
			echo 'Kontot existerar inte eller är redan aktiverat!';
		}
	}
}
?>