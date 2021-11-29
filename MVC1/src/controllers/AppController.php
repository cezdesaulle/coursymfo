<?php

class AppController {

    public static function index() {

        $players = Player::findAll();
        $contests = Contest::findAll();
        $games = Game::findAll();
        include(VIEWS . 'app/index.php');
    }
}