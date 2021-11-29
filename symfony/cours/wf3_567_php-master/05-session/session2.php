<?php
// Ouverture de la session :
session_start();// lorsque je fait session_start(), la session n'est pas recréée car elle existe déjà grâce
// au session_start() situé dans la page session1.php

echo 'La session existe toujours dans la page 2: ';
print_r($_SESSION);

// Ce fichier session2.php n'a pas de lien avec le précédent, il n'y a pas d'inclusion,
// il pourrait être dans n'importe quel dossier, s'appeler n'importe comment,
// les données contenues restent accessibles grâce à la session

echo '<p><a href="session1.php">Aller page 1</a></p>';