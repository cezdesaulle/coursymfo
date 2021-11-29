<?php

class GamesController {

    public static function add()
    {
        include(VIEWS . 'games/add.php');
    }

    public static function save() {

        $titleIsValid = false;
        $minPlayersIsValid = false;
        $maxPlayersIsValid = false;

        if (!isset($_POST['title']) || strlen($_POST['title']) < 1) {
            $_SESSION['messages']['danger'][] = 'Le titre est invalide.';
        } else { $titleIsValid = true; }

        if (!isset($_POST['min_players']) || !ctype_digit($_POST['min_players'])) {
            $_SESSION['messages']['danger'][] = 'Le nombre minimal de joueurs est invalide.';
        } else { $minPlayersIsValid = true; }

        if (!isset($_POST['max_players']) || !ctype_digit($_POST['max_players'])) {
            $_SESSION['messages']['danger'][] = 'Le nombre maximal de joueurs est invalide.';
        } else { $maxPlayersIsValid = true; }

        if ($minPlayersIsValid && $maxPlayersIsValid && $_POST['min_players'] > $_POST['max_players']) {
            $_SESSION['messages']['danger'][] = 'Le nombre maximal de joueurs doit être supérieur au nombre minimal de joueurs.';
            $minPlayersIsValid = false;
            $maxPlayersIsValid = false;
        }

        if ($titleIsValid && $minPlayersIsValid && $maxPlayersIsValid) {
            Game::create([
                'title' => $_POST['title'],
                'min_players' => $_POST['min_players'],
                'max_players' => $_POST['max_players'],
            ]);
        }

        AppController::index();
    }
}