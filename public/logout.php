<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

unset($_SESSION['Auth']);
header('Location:calendar.php'); 
?>