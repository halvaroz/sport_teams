<?php 
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$Auth->allow('admin'); ?>

<p>Une page visible que pour les admins</p>