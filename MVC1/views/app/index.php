<?php include(VIEWS . '_partials/header.php'); ?>

<div class="jumbotron">
    <h1 class="display-3">My Scoreboard</h1>
    <p class="lead">Tenez à jour vos résultats entre amis !</p>
</div>

<hr>

<div class="row">
    <div class="col">
        <h1>Joueurs</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Pseudo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($players as $player) : ?>
                    <tr>
                        <td><?= $player['id'] ?></td>
                        <td><?= $player['email'] ?></td>
                        <td><?= $player['nickname'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    <div class="col">
        <h1>Jeux</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jeu</th>
                    <th>Joueurs</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($games as $game) : ?>
                    <tr>
                        <td><?= $game['id'] ?></td>
                        <td><?= $game['title'] ?></td>
                        <td>De <?= $game['min_players'] ?> à <?= $game['max_players'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    <div class="col">
        <h1>Matchs</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jeu</th>
                    <th>Infos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contests as $contest) : ?>
                    <?php
                    $startDate = new DateTime($contest['start_date']);
                    $hasStarted = $startDate < new DateTime() ? true : false;
                    ?>
                    <?php if ($hasStarted) : ?>
                        <tr class="table-success">
                            <td><?= $contest['id'] ?><br><a href="<?= BASE_PATH . 'contests/show?id=' . $contest['id'] ?>" class="badge badge-warning">Éditer</a></td>
                            <td><?= $contest['title'] ?></td>
                            <td>
                                <span class="badge badge-primary"><?= $contest['nbPlayers'] ?> joueurs inscrits</span>
                                <span class="badge badge-secondary">A commencé le <?= $startDate->format('d/m/Y') . ' à ' . $startDate->format('H:i') ?></span>

                                <?php if (!empty($contest['nickname'])) : ?>
                                    <span class="badge badge-danger">Gagné par <?= $contest['nickname'] ?></span>

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else : ?>
                        <tr class="table-secondary">
                            <td><?= $contest['id'] ?><br><a href="<?= BASE_PATH . 'contests/show?id=' . $contest['id'] ?>" class="badge badge-warning">Éditer</a></td>
                            <td><?= $contest['title'] ?></td>
                            <td>
                                <span class="badge badge-primary"><?= $contest['nbPlayers'] ?> joueurs inscrits</span>
                                <span class="badge badge-secondary">Commencera le <?= $startDate->format('d/m/Y') . ' à ' . $startDate->format('H:i') ?></span>

                                <?php if (!empty($contest['nickname'])) : ?>
                                    <span class="badge badge-danger">Gagné par <?= $contest['nickname'] ?></span>

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<?php include(VIEWS . '_partials/footer.php'); ?>