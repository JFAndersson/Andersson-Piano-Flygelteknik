<?php
session_start();

//$DATABASE_HOST = 'sql310.epizy.com';
//$DATABASE_USER = 'epiz_30985118';
//$DATABASE_PASS = 'PaUeypXrVQ6';
//$DATABASE_NAME = 'epiz_30985118_phplogin';

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';


$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Kunde inte ansluta till SQL databasen: ' . mysqli_connect_error());
}

// Kollar ifall datan från formuläret är skickat, och genom isset() kollar ifall den existerar
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Datan kunde inte hämtas från formuläret
	exit('Vänligen ange både användarnamn och lösenord!');
}

// Förbereder SQL, vilket förebygger SQL injektioner.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {

	// Binder parametrarna (s = string, i = int, b = blob, etc)
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();

	// Lagrar resultatet så att man kan kolla ifall kontot finns i databasen
	$stmt->store_result();

    if ($stmt->num_rows > 0) {

        $stmt->bind_result($id, $password);
        $stmt->fetch();

        // Kontot existerar, så nu kan man verifiera lösenordet
        if (password_verify($_POST['password'], $password)) {
            
            // Verifikationen lyckades! Användaren har loggat in
            // Skapar sessioner så att hemsidan vet att användaren har loggat in - de fungerar som cookies fast de kommer ihåg server-data.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;

            header('Location: home.php');
        } else {
            // Inkorrekt lösenord
            header('Location: login.html'); 
        }
    } else {
        // Inkorrekt användarnamn
        header('Location: login.html');
    }


	$stmt->close();
}
?>