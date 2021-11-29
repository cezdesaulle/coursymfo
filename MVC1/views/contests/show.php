<?php include(VIEWS . '_partials/header.php'); ?>

<h1>Consulter un match</h1>

<div class="card">
    <div class="card-header">
        Match n°<?= $contest['id'] ?> : <?= $contest['title'] ?> (date de démarrage : <?= $startDate->format('d/m/Y') ?> à <?= $startDate->format('H:i') ?>) -

        <?php if ($hasStarted) : ?>
            Le match <strong>a commencé !</strong>
        <?php else : ?>
            Le match <strong>n'a pas</strong> commencé.
        <?php endif; ?>
    </div>
    <div class="card-body">

        <?php if ($contest['min_players'] > count($contestPlayers)) : ?>
            <div class="alert alert-warning">Il n'y a pas assez de joueurs inscrits pour ce jeu.</div>
        <?php endif; ?>
        <?php if ($contest['max_players'] < count($contestPlayers)) : ?>
            <div class="alert alert-warning">Il y a trop de joueurs inscrits pour ce jeu.</div>
        <?php endif; ?>

        <strong>Joueurs inscrits :</strong>
        <ul>
            <?php foreach ($contestPlayers as $player) : ?>
                <li>
                    <?= $player['nickname'] ?> (<?= $player['email'] ?>)

                    <?php if($hasStarted) : ?>
                        <?php if ($player['id'] === $contest['winnerId']) : ?>
                            <span class="badge badge-success">Gagnant du match !</span>
                        <?php else : ?>
                            <form class="form-inline my-1 ml-3" action="<?= BASE_PATH . 'contests/show/setWinner' ?>" method="post">
                                <input type="hidden" name="contest_id" value="<?= $contest['id'] ?>">
                                <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                                <button class="btn btn-sm btn-primary">Définir comme gagnant du match</button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <form class="form-inline ml-3" action="<?= BASE_PATH . 'contests/show/removePlayer' ?>" method="post">
                            <input type="hidden" name="contest_id" value="<?= $contest['id'] ?>">
                            <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    <?php endif; ?>
                    <hr>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if (!$hasStarted) : ?>
            <?php if (count($otherPlayers) == 0) : ?>
                <strong>Tous les joueurs de l'application ont été ajoutés en jeu.</strong>
            <?php else : ?>

                <form action="<?= BASE_PATH . 'contests/show/addPlayer' ?>" method="post" class="form-inline">
                    <input type="hidden" name="contest_id" value="<?= $contest['id'] ?>">
                    <div class="input-group mb-2 mr-sm-2">
                        <select name="player_id" id="addPlayer" class="form-control">
                            <?php foreach ($otherPlayers as $player) : ?>
                                <option value="<?= $player['id'] ?>"><?= $player['nickname'] ?> (<?= $player['email'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Ajouter</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include(VIEWS . '_partials/footer.php'); ?>