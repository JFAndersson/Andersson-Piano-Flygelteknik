<?php
session_start();
session_destroy();
// Skickar användaren tillbaka till startsidan
header('Location: index.php');
?>