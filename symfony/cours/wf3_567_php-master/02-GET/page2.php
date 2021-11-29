<?php
//--------------------------
// la superglobale $_GET
//----------------------------
// $_GET représente l'information qui transite dans l'URL. il s'agit d'un superglobale,
// et donc, comme toutes les superglobales, d'un array. Par ailleurs, superglobale signfie
// que cette variable est disponible dans tous les contextes du script, y compris dans
// l'espace local des fonctions sans avoir besoin de faire "global $_GET"

// Les informations transites dans l'URL selon la syntaxe suivante:
// page.php?indice1=valeur1&indice2=valeur2...

//la superglobale $_GET réceptionne les informations dans un tableau:
// $_GET = array(indice1=>valeur1, indiceN=>valeurN)

//verifier que l'on recoit l'information depuis l'URL  :
//echo '<pre>';
//echo print_r($_GET);
//echo '</pre>';

if(isset($_GET['article']) && isset($_GET['couleur']) && isset($_GET['prix'])){
echo '<h1>'.$_GET['article'].'</h1>';
echo '<p>Couleur: '.$_GET['couleur'].'</p>';
echo '<p>Prix: '.$_GET['prix'].'€</p>';
}else{
    echo '<p>Veuillez choisir un produit <a href="page1.php">ici</a></p>';
}