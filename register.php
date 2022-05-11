<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

date_default_timezone_set('Etc/UTC');

// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';


// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	exit('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	exit('Please complete the registration form');
}


if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Email is not valid!');
}

if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Username is not valid!');
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('Password must be between 5 and 20 characters long!');
}


// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Username exists, please choose another!';
	} else {
		// Username doesnt exists, insert new account
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {

	        // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
	        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	        $uniqid = uniqid();
            $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);

	        $stmt->execute();

            //Create all arguments for a smtp connection
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "jfasmtptest@gmail.com";
            $mail->Password = '03JulfhaFhA03J';
            $mail->Port = 465;
            $mail->SMTPSecure = "ssl";

            //The content inside the Email
            $from    = 'Andersson Piano & Flygelteknik';
            $subject = 'Aktivera ditt konto nedan:';
            $headers = 'Från: ' . $from . "\r\n" . 'Svara till: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" .                                            'Content-Type: text/html; charset=UTF-8' . "\r\n";

            //A url with a uniqe code and a email inbedded
            $activate_link = 'http://pianoochflygelteknik.epizy.com/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
            $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
            $mail->isHTML(true);
            $mail->setFrom('jfasmtptest@gmail.com');
            $mail->addAddress($_POST['email']);
            $mail->Subject = ("$subject");
            $mail->AddReplyTo( 'jfasmtptest@gmail.com', 'Kontakta mig' );
            $mail->Body = $message;

            if($mail->send()){
                echo 'Please check your email to activate your account!';
            }
            else{
                echo 'wrong';
            }
        } 
        else {
	        // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
            echo ":(";
        }
	}
	$stmt->close();
} 
else{
	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
    echo ":(";
}

$con->close();

?>