<?php

/**
 * Fichier contenant la configuration de l'application
 */
const CONFIG = [
    'db' => [
        'DB_HOST' => 'localhost',
        'DB_PORT' => '3306',
        'DB_NAME' => '',
        'DB_USER' => 'root',
        'DB_PSWD' => '',
    ],
    'app' => [
        'name' => 'MyScoreboard',
        'projectBaseUrl' => 'http://localhost:80/MVC'
    ]
];

/**
 * Constantes pour accéder rapidement aux dossiers importants du MVC
 */
const BASE_DIR      = __DIR__ . '/../';
const BASE_PATH     = CONFIG['app']['projectBaseUrl'] . '/public/index.php/';
const PUBLIC_FOLDER = BASE_DIR . 'public/';
const VIEWS         = BASE_DIR . 'views/';
const MODELS        = BASE_DIR . 'src/models/';
const CONTROLLERS   = BASE_DIR . 'src/controllers/';

/**
 * Liste des actions/méthodes possibles (les routes du routeur)
 */
$routes = [
    ''                          => ['AppController', 'index'],
    '/'                         => ['AppController', 'index'],
    '/players/add'              => ['PlayersController', 'add'],
    '/players/save'              => ['PlayersController', 'save'],
    '/contests/add'             => ['ContestsController', 'add'],
    '/contests/save'             => ['ContestsController', 'save'],
    '/games/add'                => ['GamesController', 'add'],
    '/games/save'                => ['GamesController', 'save'],
    '/contests/show'            => ['ContestsController', 'show'],
    '/contests/show/addPlayer'  => ['ContestsController', 'addPlayer'],
    '/contests/show/removePlayer'  => ['ContestsController', 'removePlayer'],
    '/contests/show/setWinner'  => ['ContestsController', 'setWinner'],
];
