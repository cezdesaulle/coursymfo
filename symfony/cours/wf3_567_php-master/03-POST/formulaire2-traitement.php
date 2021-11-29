<?php
if(!empty($_POST['ville']) && !empty($_POST['cp']) && !empty($_POST['adresse'])){
 //   echo '<h3>Vous avez saisi: </h3>';
   // echo '<p>ville: '.$_POST['ville'].'</p>';
   // echo '<p>code postal: '.$_POST['cp'].'</p>';
  //  echo '<p>adresse: '.$_POST['adresse'].'</p>';
//}else{
  //  echo "<h3 style='color: red'>Vous devez saisir tout les champs</h3>";


//---------------------------
// Ecrire un fichier txt
//-----------------------------
//On va écrire les adresses des internautes dans un fichier texte créé dynamiquement sur le serveur (en l'absence de BDD)

$file= fopen('adresse.txt','a') ;// fopen() en mode "a" crée le fichier s'il n'existe pas encore sinon l'ouvre

$adresse= $_POST['adresse'].'  -  '.$_POST['cp'].'  -  '.$_POST['ville']."\n"; //on concatène l'adresse de l'internaute avec un saut de ligne à la fin

fwrite($file, $adresse);// fwrite() écrit le contenu de la variable $adresse dans le fichier représenté par $file

fclose($file);// puis on ferme le fichier pour libérer de la ressource.
}
?>

