<?php
//---------------------
// La superglobale $_COOKIE
//----------------------
//un cookie est un petit fichier (4ko max) déposé par le serveur du site dans le navigateur de l'internaute
// et qui peut contenir des informations. Les cookies sont automatiuement renvoyés au serveur web par le
// navigateur quand l'internaute navigue dans les pages concernées par le cookie. PHP permet de récupérer
// facilement les données contenues dans un cookie: ses informations sont stockées dans la superglobale $_COOKIE


// Précaution à prendre avec les cookies: étant sauvegardé sur le poste de l'internaute, le cookie peut être volé ou modifié.
//on y met donc pas d'informations sensibles (prix de panier, cb, mdp...) mais des préférences ou des traces de visite par exemple.

// Application: nous allons stocker la langue sélectionné par l'internaute dqns un cookie.

// 2- On détermine la langue d'affichage pour l'internaute:
if(isset($_GET['langue'])) { //si on a cliqué sur une langue, l'indice langue est passé dans l'URL donc se trouve dans $_GET
    $lange = $_GET['langue'];// on affecte alors la valeur de la langue à la variable $langue
}elseif (isset($_COOKIE['langue'])){ // sinon si on a reçu un cookie appelé langue
    $lange=$_COOKIE['langue']; // on affecte la valeur stockée dans le cookie
}else{
    $lange='fr'; // par défaut si on a pas cliqué et qu'aucun cookie n'éxiste la langue sera 'fr'
}

// 3- On envoie le cookie:
$un_an=time() + 365*24*60*60; // time() retourne le timestamp de l'instant présent auquel on ajoute 1 ans exprimé en secondes




setcookie('langue', $lange, $un_an); // on envoie un cookie appelé "langue" avec la valeur celle qui est
// dans $langue, et pour date d'expiration $un_an

// 4-on affiche la langue:
echo "<h2>Langue du site : $lange</h2>"

// setcookie() permet de créer un cookie. cependant il n'y a pas de fonction prédéfinie permettant de
// le supprimer. Pour cela, on le met à jour avec une date périmée, ou à zero, ou encore en mettant
// juste le nom du cookie sans les autres arguments

// 1- Le HTML
?>

<h1>langue</h1>
<ul>
    <li><a href="?langue=fr">français</a></li>
    <li><a href="?langue=es">espagnol</a></li>
    <li><a href="?langue=en">anglais</a></li>
    <li><a href="?langue=it">italien</a></li>
</ul>

<?php echo date("Y")+1;?>