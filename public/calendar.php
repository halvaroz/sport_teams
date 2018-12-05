<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require '../src/bootstrap.php';
require '../src/Calendar/Events.php';
require '../src/Calendar/Month.php';

$pdo = get_pdo();
$events = new Calendar\Events($pdo);
$month = new Calendar\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$start = $month->getStartingDay();

$start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');

$weeks = $month->getWeeks();
$end = $start->modify('+' . (6 + 7 * ($weeks -1)) . ' days');


$events = $events->getEventsBetweenByDay($start, $end);
$counter=0;
   
if (isset($_GET['year']) && isset($_GET['month'])){
  $currentMonth = $_GET['year'].'-'.$_GET['month'];

}

require '../views/header.php';

?>


<?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
          L'évènement a bien été enregistré
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">
          L'évènement a bien été supprimé
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['logged'])): ?>
      
        <div class="alert alert-success">
          Vous êtes connecté !
        </div>
      
    <?php endif; ?>
  
  <?php require '../views/calendar/sidecalendar.php'; ?>
  <div class="table-container">
    
  

  <table class="calendar__table calendar__table--<?= $weeks; ?>weeks">
      <caption> <?= $month->toString(); ?></caption><div class="calendar-nav">
         <a href="./calendar.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn cal_pages btn-primary">&lt;</a>
        <a href="./calendar.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn cal_pages btn-primary">&gt;</a>
      
      </div>
      <tr class="cal__weekdays"><th scope="col" class="calendar__weekday">Lundi</th><th scope="col" class="calendar__weekday">Mardi</th><th scope="col" class="calendar__weekday">Mercredi</th><th scope="col" class="calendar__weekday">Jeudi</th><th scope="col" class="calendar__weekday">Vendredi</th><th scope="col" class="calendar__weekday">Samedi</th><th scope="col" class="calendar__weekday">Dimanche</th></tr>
   
      <?php for ($i = 0; $i < $weeks; $i++): ?>
        <tr>
            <?php
            foreach($month->days as $k => $day):
                $date = $start->modify("+" . ($k + $i * 7) . " days");
                $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
                $isToday = date('Y-m-d') === $date->format('Y-m-d');
                $odd=true;

                ?>
              <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?> <?= $isToday ? 'is-today' : ''; ?>">
                  
                <div class="day__header"><a class="calendar__day" href="add.php?date=<?= $date->format('Y-m-d'); ?>"><?= $date->format('d'); ?></a>
                   <?php foreach($eventsForDay as $event): ?>
                    
                    <img class="sexe-logo <?= $event->getSexe()?>" src="img/<?= $event->getSport()?>.png">
                   
                  <?php endforeach; ?>
                </div>
                  <?php foreach($eventsForDay as $event): ?>
                    <div class="calendar__event team-<?= $event->getTeamId() ?> <?= ($odd) ? 'odd__event' : 'even__event'; ?>" title="<?= $event->getDescription()?>">
                        <?= $event->getStart()->format('H:i') ?>  <a href="edit.php?id=<?= $event->getId(); ?>"><?= h($event->getTeams()); ?></a>
                    </div>
                  <?php $odd = !$odd; endforeach; ?>
              </td>
            <?php endforeach; ?>
        </tr>
      <?php endfor; ?>
    
  </table>

</div>

<?php if(isset($_SESSION['Auth'])): ?>
<a href="add.php" class="add__button">+</a>
<?php endif; ?>
<script src="js/calendar.js"></script>
<?php require '../views/footer.php'; ?>
