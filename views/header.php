<?php 
if(session_status() == PHP_SESSION_NONE){
    session_start();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/calenda.css">
    <link rel="stylesheet" href="css/button.css">
  <title><?= isset($title) ? h($title) : 'Calendrier'; ?></title>
</head>
<body>

<nav class="navbar navbar-dark bg-primary mb-3">
    <h1 class="navbar-brand">Où et quand voir les équipes de sport nantaises en 2018/2019</h1>

     <?php if(!isset($_SESSION['Auth'])): ?>
    	<a href="login.php" class="navbar-brand">Login</a>
    	<?php else: ?>
    	    <a href="logout.php" class="navbar-brand">Logout</a>
    	<?php endif; ?>

</nav>
<div class="my_cal_container">
<a href="index.php">
    <div class="styled-button map-button" >
      <i class="fas fa-map-marker-alt"></i>
      <span>CARTE</span>
    </div>
  </a>

