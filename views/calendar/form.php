<?php if(!isset($_GET['id']) && !isset($_GET['teamId'])): ?>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="teamId">Équipe</label>
            <select name="teamId" id='teamId' title="zeze">
                <option value="" selected disabled>Sélection de l'équipe :</option>
                <option value="1">FC Nantes</option>
                <option value="2">HBC Nantes</option>
                <option value="3">Nantes Rezé Métropole Volley</option>
                <option value="4">Volley-Ball Nantes</option>
                <option value="5">Nantes Rezé Basket</option>
                <option value="6">Nantes Basket Hermine</option>
                <option value="7">Nantes Atlantique HandBall</option>
                <option value="8">Stade Nantais Rugby</option>
                <option value="9">Nantes Atlantique Hockey Glace</option>
                <option value="10">Nantes Atlantique Rink Hockey</option>
                <option value="11">Nantes Métropole Futsal</option>
            </select>
        </div>
    </div>
    
</div>
<?php else :?>
    <?php 
    if (!isset($_GET['teamId'])){
        $pdo = get_pdo();
        $events = new Calendar\Events($pdo);
        $search = $events->find($_GET['id']);
        $team = $search->getTeamId();
    } else {
        $team = $_GET['teamId'];
    }
   
            ?>
    <input id="teamId" name="teamId" type="hidden" value="<?= $team ?>">
<?php endif ?>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="teams">Match</label>
            <input id="teams" type="text" required class="form-control" name="teams" value="<?= isset($data['teams']) ? h($data['teams']) : ''; ?>">
            <?php if (isset($errors['teams'])): ?>
                <small class="form-text text-muted"><?= $errors['teams']; ?></small>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="date">Date</label>
            <input id="date" type="date" required class="form-control" name="date" value="<?= isset($data['date']) ? h($data['date']) : ''; ?>">
            <?php if (isset($errors['date'])): ?>
                <small class="form-text text-muted"><?= $errors['date']; ?></small>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="start">Début</label>
            <input id="start" type="time" required class="form-control" name="start" placeholder="HH:MM" value="<?= isset($data['start']) ? h($data['start']) : ''; ?>">
            <?php if (isset($errors['start'])): ?>
                <small class="form-text text-muted"><?= $errors['start']; ?></small>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="end">Fin</label>
            <input id="end" type="time" required class="form-control" name="end" placeholder="HH:MM" value="<?= isset($data['end']) ? h($data['end']) : ''; ?>">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control"><?= isset($data['description']) ? h($data['description']) : ''; ?></textarea>
</div>
