<?php
//--------------------------
// La superglobale $_SESSION
//---------------------------
// Principe des sessions : un fichier temporaire appelé session est créé sur le serveur avec
// un identifiant unique. cette session est liée à un internaute car dans le même temps,
// un cookie est déposé dans son navigateur avec l'identifiant (au nom PHPSESSID). ce cookie
// se détruit lorsqu'on quitte le navigateur.

// La session peut contenir toutes sortes d'infomations, y compris sensible car elle n'est pas accéssible
// par l'internaute, donc pas modifiable par celui-ci. On y stocke les données de login, les
// paniers d'achats....

// Tous les sites qui fonctionnent sur le principe de connexion (site bancaire...) ou qui ont besoin
// de suivre un internaute de page en page(avec son panier par exemple) utilisent des sessions.

// Les données du fichier de session sont accessibles et manipulable à partir de la superglobale $_SESSION

// Création d'une session:
session_start();//permet de créer un fichier de session OU de l'ouvrir s'il existe déjà

// Remplissage du fichier de session :
$_SESSION['pseudo']='tintin';
$_SESSION['mdp']='milou'; // $_SESSION étant une superglobale est un array,
// on accède donc à ses valeurs en passant par les indices écrit entre[]

echo '1_La session après remplissage :';
print_r($_SESSION);
// Les sessions se trouvent dans le dossier xampp/tmp/

// vider une partie de la session :
unset($_SESSION['mdp']);// nous supprimons le mot de passe avec unset()

echo '<br> 2_ la session après suppression du mdp : ';
print_r($_SESSION);

// Spression de toute la session :
//session_destroy(); // suppression de la session Mais il faut savoir que le session_destroy() est d'abord
// vu par l'interpréteur qui ne l'éxécute qu'à la fin du script


echo '<br> 3_ La session après supression : ';
print_r($_SESSION); // nous avons fait un session_destroy() mais il ne sera éxécuté qu'à la fin de ce script,
// c'est la raison pour laquelle nous avons encore accès aux informations ici

//Les sessions ont l'avantage d'être disponible partout sur le site: voir session2.php

echo '<p><a href="session2.php">Aller page 2</a>';
