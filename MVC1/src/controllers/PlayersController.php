<?php

class PlayersController {

    public static function add()
    {
        include(VIEWS . 'players/add.php');
    }

    public static function save()
    {
        $emailIsValid = false;
        $nicknameIsValid = false;

        $players = Player::findAll();
        $emails = array_column($players, 'email');
        $nicknames = array_column($players, 'nickname');

        if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['messages']['danger'][] = 'L\'adresse e-mail est invalide.';
        } else if (in_array($_POST['email'], $emails)) {
            $_SESSION['messages']['danger'][] = 'L\'adresse e-mail existe déjà.';
        } else {
            $emailIsValid = true;
        }

        if (!isset($_POST['nickname']) || strlen($_POST['nickname']) < 1) {
            $_SESSION['messages']['danger'][] = 'Le pseudo ne peut pas être vide.';
        } else if (in_array($_POST['nickname'], $nicknames)) {
            $_SESSION['messages']['danger'][] = 'Le pseudo existe déjà.';
        } else {
            $nicknameIsValid = true;
        }

        if ($emailIsValid && $nicknameIsValid) {
            Player::create([
                'email' => $_POST['email'],
                'nickname' => $_POST['nickname'],
            ]);
        }

        AppController::index();    }

}