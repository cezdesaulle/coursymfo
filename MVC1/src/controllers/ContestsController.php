<?php

class ContestsController {

    public static function add()
    {
        $games = Game::findAll();
        include(VIEWS . 'contests/add.php');
    }

    public static function save() {
        $games = Game::findAll();
        $gamesId = array_column($games, 'id');

        $gameIsValid = false;
        $dateIsValid = false;
        /**
         * Check du jeu
         */
        if (!isset($_POST['game_id']) || !in_array($_POST['game_id'], $gamesId)) {
            $_SESSION['messages']['danger'][] = 'Le jeu choisi est invalide.';
        }
        else {
            $gameIsValid = true;
        }

        /**
         * Check de la date
         */
        $startDate = DateTime::createFromFormat("Y-m-d\TH:i", $_POST['start_date']);

        if  (!$startDate || $startDate->format("Y-m-d\TH:i") !== $_POST['start_date']) {
            $_SESSION['messages']['danger'][] = 'La date saisie est invalide.';
        }
        else if ($startDate < new DateTime()) {
            $_SESSION['messages']['danger'][] = 'La date saisie doit être supérieure à la date actuelle.';
        }
        else {
            $dateIsValid = true;
        }

        if ($gameIsValid && $dateIsValid) {
            Contest::create([
                'game_id' => $_POST['game_id'],
                'start_date' => $startDate->format('Y-m-d H:i:s')
            ]);
        }

        AppController::index();
    }

    public static function show()
    {
        $contest = Contest::findOne($_GET['id']);
        $contestPlayers = Contest::getPlayers($_GET['id']);
        $otherPlayers = Contest::findNotRegisteredPlayers($_GET['id']);

        $startDate = new DateTime($contest['start_date']);
        $hasStarted = $startDate < new DateTime() ? true : false;

        include(VIEWS . 'contests/show.php');
    }

    public static function addPlayer()
    {
        $playerId = $_POST['player_id'];
        $contestId = $_POST['contest_id'];

        $contestPlayers = Contest::getPlayers($contestId);
        $registeredPlayersId = array_column($contestPlayers, 'id');

        if (!in_array($playerId, $registeredPlayersId)) {
            Contest::addPlayer($contestId, $playerId);
        }


        header('Location: ' . BASE_PATH . 'contests/show?id=' . $contestId);
    }

    public static function removePlayer()
    {
        $playerId = $_POST['player_id'];
        $contestId = $_POST['contest_id'];

        $contestPlayers = Contest::getPlayers($contestId);
        $registeredPlayersId = array_column($contestPlayers, 'id');

        if (in_array($playerId, $registeredPlayersId)) {
            Contest::removePlayer($contestId, $playerId);
        }

        header('Location: ' . BASE_PATH . 'contests/show?id=' . $contestId);
    }

    public static function setWinner()
    {
        $playerId = $_POST['player_id'];
        $contestId = $_POST['contest_id'];

        $contestPlayers = Contest::getPlayers($contestId);
        $registeredPlayersId = array_column($contestPlayers, 'id');

        if (in_array($playerId, $registeredPlayersId)) {
            Contest::setWinner($contestId, $playerId);
        }


        header('Location: ' . BASE_PATH . 'contests/show?id=' . $contestId);
    }
}