<?php 
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
$Auth->allow('member');

$pdo = get_pdo();
$req = $pdo->prepare('SELECT address FROM users WHERE id=:id');

$req->execute(array(
    'id' => $Auth->user('id')                   
)); 
$user = $req->fetch();

?>

<h1>Mon compte</h1>
<p>Mon adresse : </p>
<p><strong><?php echo $user['address']; ?></strong></p>