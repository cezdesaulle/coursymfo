<?php
// Connexion à la BDD
$pdo = new PDO('mysql:host=localhost;dbname=repertoire',
    'root',
    '',
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    )
);

// Création ou ouverture de session
session_start();

// Chemin du site
define('RACINE_SITE', '/PHP/09-EXO/'); // on indique ici les dossiers dans lesquels se situe le site à partir de "localhost". cela permet de créer des chemins absolu à partir de "localhost" (caractérisés par le / au début).ILs sont utilisés notamment dans header.php qui peut être inclus dans des fichiers appartenant à des dossiers ou des sous-dossiers différents : par conséquent les chemins relatifs vers les sources changeraient, alors que les chemins absolus sont les mêmes.

// Variable d'affichage
$contenu = '';