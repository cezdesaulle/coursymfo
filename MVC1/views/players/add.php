<?php include(VIEWS . '_partials/header.php'); ?>

<h1>Ajout d'un joueur</h1>

<form action="<?= BASE_PATH . "players/save" ?>" method="post">

    <div class="form-group">
        <label for="">Email</label>
        <input name="email" type="email" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Pseudo</label>
        <input name="nickname" type="text" class="form-control">
    </div>

    <button class="btn btn-primary float-right">Ajouter un joueur</button>

</form>

<?php include(VIEWS . '_partials/footer.php'); ?>