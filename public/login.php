<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require '../src/bootstrap.php';
require "class.auth.php";

if($Auth->user('id')){
    header('Location: calendar.php?logged=2');
    exit();
}

if(!empty($_POST)){
    if($Auth->login($_POST)){
        header('Location: calendar.php?logged=1');
        exit();
    }else{
        header('Location: login.php?error=1');
        exit;
    }
}
require '../views/header.php';

?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
      Identifiant ou mot de passe incorrect
    </div>
<?php endif; ?>

<h1>Se connecter</h1>
<form method="post" action="">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="">Login : </label>
            <input class="form-control" type="text" name="login"/>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="">Mot de passe : </label>
            <input class="form-control" type="password" name="password"/>
        </div>
    </div>
    <div class="form-group">
        <button class="login-btn btn btn-primary">Se connecter</button>
    </div>
</form>
<?php require '../views/footer.php';?>
