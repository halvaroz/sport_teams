<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require "class.auth.php";
require '../src/bootstrap.php';

require '../src/Calendar/EventValidator.php';
require '../src/Calendar/Events.php';

$pdo = get_pdo();
$Auth->allow('admin');

$data = [
    'teamId' => $_GET['teamId'] ?? null,
    'date'  => $_GET['date'] ?? date('Y-m-d'),
    'start' => date('H:i'),
    'end'   => date('H:i')
];

$validator = new \App\Validator($data);
if (!$validator->validate('date', 'date')) {
    $data['date'] = date('Y-m-d');
}
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $validator = new Calendar\EventValidator();
    $errors = $validator->validates($_POST);
  
    if (empty($errors)) {
        $events = new \Calendar\Events(get_pdo());
        $event = $events->hydrate(new \Calendar\Event(), $data);
        $events->create($event);
        header('Location: ./calendar.php?success=1');
        exit();
    }
}

render('header', ['title' => 'Ajouter un évènement']);
?>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    Merci de corriger vos erreurs
  </div>
<?php endif; ?>

  <h1>Ajouter un évènement</h1>
  <form action="" method="post" class="form">
      <?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
    <div class="form-group">
      <button class="btn btn-primary">Ajouter l'évènement</button>
    </div>
  </form>
  
<?php render('footer'); ?>
