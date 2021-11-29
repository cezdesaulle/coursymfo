<?php include(VIEWS . '_partials/header.php'); ?>

<h1>Ajout d'un match</h1>

<form action="<?= BASE_PATH . "contests/save" ?>" method="post">

    <div class="form-group">
        <label for="">Choix du jeu</label>
        <select name="game_id" id="" class="form-control">
            <?php foreach($games as $game) : ?>
                <option value="<?= $game['id'] ?>"><?= $game['title'] ?> (entre <?= $game['min_players'] ?> et <?= $game['max_players'] ?> joueurs)</option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="">Date de démarrage</label>
        <input name="start_date" type="datetime-local" class="form-control">
    </div>


    <button class="btn btn-primary float-right">Ajouter un match</button>

</form>

<?php include(VIEWS . '_partials/footer.php'); ?>