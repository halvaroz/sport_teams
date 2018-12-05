<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
	}
require '../src/bootstrap.php';
require '../views/header.php';
?>

<h1>Bonjour</h1>

<?php require '../views/footer.php';?>