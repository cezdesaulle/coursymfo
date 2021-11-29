<?php
//--------------------------------
// La superglobale $_POST
//---------------------------------
//$_POST est une superglobale qui permet de récupérer les données saisies dans un formulaire


// $_POST étant une superglobale, est donc un array et est disponible dans tout les contextes du script
// y compris au sein des fonctions sans y faire "global $_POST"

// Les données saisies dans le formulaire sont réceptionnées dans $_POST de la manière suivante :
// $_POST = array ('name1'=>'valeur_input1', 'nameN'=>'valeur_inputN');

echo '<pre>';
print_r($_POST);
echo '</pre>';

if(!empty($_POST)){// si $_POST n'est pas vide, c'est que l'on a reçu les données du formulaire, on peut donc les afficher
echo '<p>prénom: '.$_POST['prenom'].'</p>';
echo '<p>description: '.$_POST['description'].'</p>';}

//Remarque :
// cliquer dans l'URL et faire entré permet de réinitialiser les formulaires
// faire f5 ou ctr+r permet de rafraichir la page et de renvoyer les dernières données saisies dans le formulaire

?>

<h1>Formulaire</h1>

<form action="" method="post"><!--un formulaire doit toujours être dans une balise <form> pour fonctionner,
l'attribut method définit comment les données vont transiter entre le navigateur et le serveur,
l'attribut action définit l'URL de destination des données saisies -->
    <div><label for="prenom">Prénom</label></div>
    <div><input type="text" name="prenom" id="prenom"></div><!-- il ne faut pas oublier les "name" dans les formulaires:
    ils constituent les indices du tableau $_POST qui receptionneles données-->
    <div><label for="description">Description</label></div><!-- l'attribut "for" n'est pas indispensable
    mais il permet de relier le label à l'input qui porte un id de même valeur.
    Ainsi quand on clique sur l'étiquette, le curseur se positionne dans l'input-->
    <div><textarea name="description" id="description"></textarea></div>
    <hr>
    <button type="submit">Valider</button>
</form>