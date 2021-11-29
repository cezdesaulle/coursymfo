<?php include(VIEWS . '_partials/header.php'); ?>

<h1>Ajout d'un jeu</h1>


<form action="<?= BASE_PATH . "games/save" ?>" method="post">

    <div class="form-group">
        <label for="">Nom du jeu</label>
        <input name="title" type="text" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Nombre de joueurs minimum</label>
        <input name="min_players" type="number" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Nombre de joueurs maximum</label>
        <input name="max_players" type="number" class="form-control">
    </div>

    <button class="btn btn-primary float-right">Ajouter un jeu</button>

</form>

<?php include(VIEWS . '_partials/footer.php'); ?>