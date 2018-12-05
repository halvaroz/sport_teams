<?php

require '../src/Calendar/Events.php';


if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require '../src/bootstrap.php';

$pdo = get_pdo();
$events = new Calendar\Events($pdo);
$events = $events->delete($_GET['id']);

header('Location: ../public/calendar.php?deleted=1');
