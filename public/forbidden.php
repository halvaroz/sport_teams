<?php 
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require '../views/header.php'; ?>

<div class="container">
    <div class="alert alert-danger">Vous n'avez pas accès à cette page.</div>
	<h1>Accès refusé</h1>
	<a class="log__link" href="login.php">Se connecter</a>
</div>

<?php require '../views/footer.php'; ?>