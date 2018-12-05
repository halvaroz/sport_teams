<?php

require '../src/Calendar/Events.php';
require '../src/Calendar/EventValidator.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require "class.auth.php";

require '../src/bootstrap.php';

$pdo = get_pdo();
$Auth->allow('admin');

$events = new Calendar\Events($pdo);
$errors = [];
try {
    $event = $events->find($_GET['id'] ?? null);
} catch (\Exception $e) {
    e404();
} catch (\Error $e) {
    e404();
}

$data = [
    'teamId'      => $event->getTeamId(),
    'teams'       => $event->getTeams(),
    'date'        => $event->getStart()->format('Y-m-d'),
    'start'       => $event->getStart()->format('H:i'),
    'end'         => $event->getEnd()->format('H:i'),
    'description' => $event->getDescription()
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_button'])) {
    
    $data = $_POST;
    $validator = new Calendar\EventValidator();
    $errors = $validator->validates($data);

    if (empty($errors)) {
        $events->hydrate($event, $data);
        $events->update($event);
        header('Location: calendar.php?success=1');
        exit();
    }
}

render('header', ['title' => $event->getTeams()]);

?>
<div class="container">
  <h1>Editer l'évènement
    <small><?= h($event->getTeams()); ?></small>
  </h1>

  <form action="" method="post" class="form">
    <?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
    <div class="form-group">
      <button class="btn btn-primary" name="update_button" id="update_button">Modifier l'évènement</button>
      <input class="btn btn-danger" name="delete_button" id="delete_button" value="Supprimer l'évènement" data-id="<?= $_GET['id']?>">
    </div>
  </form>
</div>
<script src="js/edit.js"></script>

<?php render('footer'); ?>
