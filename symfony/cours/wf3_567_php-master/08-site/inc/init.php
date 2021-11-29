<?php
/*
 * Le fichier init sera inclus dans tout les scripts (hors inclusions) pour initialiser :
 * -la connexion à la BDD
 * -la création ou l'ouverture de la session
 * -la définition du chemin du site sur le serveur
 * -l'inclusion du fichier functions.php
 *
 */

// Connexion à la BDD
$pdo = new PDO('mysql:host=localhost;dbname=site_commerce',
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
define('RACINE_SITE', '/PHP/08-site/'); // on indique ici les dossiers dans lesquels se situe le site à partir de "localhost". cela permet de créer des chemins absolu à partir de "localhost" (caractérisés par le / au début).ILs sont utilisés notamment dans header.php qui peut être inclus dans des fichiers appartenant à des dossiers ou des sous-dossiers différents : par conséquent les chemins relatifs vers les sources changeraient, alors que les chemins absolus sont les mêmes.

// Variable d'affichage
$contenu = '';

// l'inclusion des fonctions :
require_once 'functions.php'; // fait l'inclusion une seule fois du fichier spécifié