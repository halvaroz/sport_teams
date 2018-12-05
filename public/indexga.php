<?php
session_start();
require '../src/bootstrap.php';

// Instance PDO
try{
	$pdo = get_pdo();
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
}catch(PDOException $e){
	echo 'Connexion impossible';
}

// Class Auth
require "class.auth.php";

ob_start();
include((isset($_GET['p']) ? $_GET['p'] : 'home').'.php');
$content_for_layout = ob_get_clean(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../theme/style.css" type="text/css" media="screen" />
  </head>

  <body>
    <div id="conteneur">
        
      <?php if($Auth->user('id')): ?>
      <h1>Bonjour <?php echo $Auth->user('login'); ?></h1>
      <ul>
          <li><a href="indexga.php?p=compte">Mon compte</a></li>
          <?php if($Auth->user('role') == 'admin'): ?>
          <li><a href="indexga.php?p=admin">Administration</a></li>
          <?php endif; ?>
          <li><a href="indexga.php?p=logout">Se déconnecter</a></li>
          
      </ul>
      <?php else: ?>
        <a href="indexga.php?p=login">Se connecter</a>
      <?php endif; ?>
        
          <?php echo $content_for_layout; ?>
          <h1>Session</h1>
          <pre><?php print_r($_SESSION); ?></pre>
      </div>
  </body>