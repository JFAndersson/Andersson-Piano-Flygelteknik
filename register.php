<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

date_default_timezone_set('Etc/UTC');

// Anslutningsinfo
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';


// Försöker skapa en anslutning utifrån värdena ovan
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// Om det sker anslutningsproblem stoppas koden och följande error skrivs ut
	exit('Kunde inte ansluta till SQL databasen: ' . mysqli_connect_error());
}

// Nu kollas så att datan kunde skickas in, och isset() metoden används därefter för att se om datan existerar
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Kunde inte hitta datan som skickades
	exit('Vänligen färdigställ registreringsformuläret');
}
// Ser till så att inmatningsrutorna inte är tomma
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// Ett eller flera värden är null
	exit('Vänligen färdigställ registreringsformuläret');
}


if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('E-post addressen är inte giltig!');
}

if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Användarnamnet är inte giltigt!');
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('Lösenordet måste vara mellan 5 till 20 karaktärer långt!');
}


// Undersöker om ett konto med det användarnamnet existerar
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {

	// Sammanför parameterarna (s = string, i = int, b = blob, etc), hashar lösenordet genom PHP password_hash metoden
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();

	// Lagrar resultatet so att vi sedan kan kolla om kontot existerar i databasen
	if ($stmt->num_rows > 0) {
		// Användarnamnet existerar redan
		echo 'Användarnamnet existerar redan, vänligen välj ett annat!';
	} else {
		// Användarnamnet existerar inte, så resterande detaljer förs in
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {

	        // Man vill inte läcka lösenorden i databasen, så de hashas och dekrypteras med password_verify när användaren loggar in
	        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	        $uniqid = uniqid();
            $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);

	        $stmt->execute();

            // Skapar alla parametrar för SMTP anslutningen
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "jfasmtptest@gmail.com";
            $mail->Password = '03JulfhaFhA03J';
            $mail->Port = 465;
            $mail->SMTPSecure = "ssl";

            // E-mejlets innehåll
            $from    = 'Andersson Piano & Flygelteknik';
            $subject = 'Aktivera ditt konto nedan:';
            $headers = 'Från: ' . $from . "\r\n" . 'Svara till: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" .                                            'Content-Type: text/html; charset=UTF-8' . "\r\n";

            // En url kod införs som har länken till verifieringssidan och annan anslutningsinfo
            $activate_link = 'localhost/anderssonPiano/html/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
            $message = '<p>Klicka på den följande länken för att aktivera ditt konto: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
            $mail->isHTML(true);
            $mail->setFrom('jfasmtptest@gmail.com');
            $mail->addAddress($_POST['email']);
            $mail->Subject = ("$subject");
            $mail->AddReplyTo( 'jfasmtptest@gmail.com', 'Kontakta mig' );
            $mail->Body = $message;

            if($mail->send()){
                echo 'Kolla din inbox för mejlet som aktiverar ditt konto!';
            }
            else{
                echo 'Mejlet kunde inte skickas';
            }
        } 
        else {
	        // Något är fel med SQL koden, se till så att databasen har korrekt struktur
            echo "Något är fel med SQL koden, se till så att databasen har korrekt struktur";
        }
	}
	$stmt->close();
} 
else{
	// Något är fel med SQL koden, se till så att databasen har korrekt struktur
    echo "Något är fel med SQL koden, se till så att databasen har korrekt struktur";
}

$con->close();

?>