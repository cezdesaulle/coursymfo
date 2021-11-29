<?php
//***************************************
//                 PDO
//---------------------------------------
//L'extension PDO, pour PHP Data Object définit une interface pour accéder à une base de données depuis PHP, et permet
//d'y éxécuter des requêtes sql

function debug($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}


//------------------------------
echo '<h2>Connexion à la BDD</h2>';
//-------------------------------

$pdo = new PDO('mysql:host=localhost;dbname=entreprise',
    'root',
    '',
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    )
);

//------------------------------
echo '<h2>Requête avec exec() </h2>';
//-------------------------------
//Nous insérons un employé:

$resultat = $pdo->exec("INSERT INTO employes (prenom, nom, sexe,service,date_embauche,salaire) VALUES ('test','test','m','test','2020-08-26',1500)");

/*
 * exec() est utilisé pour la formulation de requêtes ne retournant pas de résultat: INSERT, UPDATE, DELETE.
 *
 * Valeur de retour:
 * succés: renvoie le nombre de lignes affectées
 * echec : false
 */

echo "Nombre d'enregistrements affectés par l'INSERT : $resultat<br>";
echo "dernier ID généré en BDD : " . $pdo->lastInsertId() . "<br>";

//---------------
$resultat = $pdo->exec("DELETE FROM employes WHERE prenom = 'test'");
echo "Nombre d'enregistrements affectés par le DELETE :$resultat.<br>'";

//------------------------------
echo '<h2>Requêtes avec query() et fetch() pour 1 seul résultat</h2>';
//-------------------------------
$resultat = $pdo->query("SELECT * FROM employes WHERE prenom='daniel'");

/*
 * Au contraire de exec(), query() est utilisé pour la formulation de requêtes qui retournent un ou plusieurs résultats : SELECT.
 *
 * Valeur de retour :
 * Succès : query() retourne un objet qui provient de la classe PDOstatement
 * Echec : false
 */

debug($resultat);// $resultat est le résultat de la requête séléction sous forme inexploitable directement.
// En effet nous ne voyons pas les informations de daniel. Pour accéder à ces informations,
// il nous faut utiliser la méthode fetch():

$employe = $resultat->fetch(PDO::FETCH_ASSOC); //
debug($employe); //la methode fetch() avec le paramêtre PDO::ETCH_ASSOC retourne un tableau associatif
// exploitable dont les indices correspondent aux noms des champs de la requête. Ce tableau contient
// les données de daniel
echo 'je suis ' . $employe['prenom'] . '  ' . $employe['nom'] . ' du service ' . $employe['service'] . '<br>';

// on peut aussi utiliser les méthodes suivantes:
// 1_
$resultat = $pdo->query("SELECT * FROM employes WHERE prenom='daniel'");
$employe = $resultat->fetch(PDO::FETCH_NUM);// pour otenir un tableau indexé numeriquement
debug($employe);
echo 'je suis ' . $employe[1] . '  ' . $employe[2] . ' du service ' . $employe[4] . '<br>';

// 2_
$resultat = $pdo->query("SELECT * FROM employes WHERE prenom='daniel'");
$employe = $resultat->fetch();// pour obtenir un mélane de tableau associatif et numérique
debug($employe);
echo 'je suis ' . $employe[1] . '  ' . $employe[2] . ' du service ' . $employe[4] . '<br>';

// 3_
$resultat = $pdo->query("SELECT * FROM employes WHERE prenom='daniel'");
$employe = $resultat->fetch(PDO::FETCH_OBJ);// retourne un objet avec le nom
// des champs comme propriétés publiques
debug($employe);
echo 'je suis ' . $employe->prenom . ' ' . $employe->nom . ' du service ' . $employe->service . '<br>';

// Note: vous ne pouvez pas faire plusieurs fetch() sur le même résultat, ce pourquoi nous répétons ici la requête.

//------------------
// EXO :
$resultat = $pdo->query("SELECT service FROM employes WHERE id_employes=417");
$employe = $resultat->fetch(PDO::FETCH_ASSOC);
debug($employe);
echo 'le service de l\'employé ayant l\'ID 417 est: ' . $employe['service'] . '<br>';

//------------------------------
echo '<h2>Requêtes avec query() et fetch() pour plusieurs résultats</h2>';
//-------------------------------
$resultat = $pdo->query("SELECT * FROM employes");

echo "Nombre d'employes : " . $resultat->rowCount() . '<br>'; // compte le nombre de lignes dans l'objet $resultat
// (contexte: nombre de produits dans une boutique)

debug($resultat);

//comme nous avons plusieurs lignes dans $resultat, nous devons faire une boucle pour les parcourir:
while ($employe = $resultat->fetch(PDO::FETCH_ASSOC)) {// fetch() va chercher la ligne suivante
    // du jeu de résultats qu'il retourne en tableau associatif. La boucle while permet de faire
    // avancer le curseur  dans la table et s'arrête quand le curseur est à la fin des résultats
    // (quand fetch retourne false)

    debug($employe);
    echo '<div>';
    echo '<div>' . $employe['prenom'] . '</div>';
    echo '<div>' . $employe['nom'] . '</div>';
    echo '<div>' . $employe['service'] . '</div>';
    echo '<div>' . $employe['salaire'] . ' €</div>';
    echo '</div><hr>';
}
//------------------------------
echo '<h2>La méthode fetchAll()</h2>';
//-------------------------------
$resultat = $pdo->query("SELECT * FROM employes");
$donnees = $resultat->fetchAll(PDO::FETCH_ASSOC); // fetchAll() retourne toutes les lignes de $resultat
// dans un tableau multidimensionnel: on a 1 tableau associatif par emplyé rangé à chaque indice numérique.
// Pour info, on peut aussi faire FETCH_NUM pour un sous tableau numérique, ou fetchAll()sans paramêtre
// pour un sous tableau numérique et associatif.
debug($donnees);// il s'agit d'un tableau multidimensionnel

// on parcourt le tableau $donnees avec une boucle foreach pour en afficher le contenu :
foreach ($donnees as $donnee => $employe) {// $employe est lui même un tableau. on accède donc à ses valeurs par les indices entre [].
    //debug($employe);
    echo '<div>';
    echo '<div>' . $employe['prenom'] . '</div>';
    echo '<div>' . $employe['nom'] . '</div>';
    echo '<div>' . $employe['service'] . '</div>';
    echo '<div>' . $employe['salaire'] . ' €</div>';
    echo '</div><hr>';
}

//------------------------------
echo '<h2>Exercice</h2>';
//-------------------------------
$resultat = $pdo->query("SELECT service FROM employes GROUP BY service");// ne pas oublier de refaire la requête
// avant un nouveau fetch, sinon on est déjà hors du jeu de résultat et donc il n'y a plus rien à récupérer
$services = $resultat->fetchAll(PDO::FETCH_ASSOC);
debug($services);
echo '<ul>';
foreach ($services as $service) {

    echo '<li>' . $service['service'] . '</li>';

}
echo '</ul>';

//------------------------------
echo '<h2>Table html</h2>';
//-------------------------------

$resultat = $pdo->query("SELECT * FROM employes");
?>
    <style>
        table, th, tr, td {
            border: 1px solid;
        }

        table {
            border-collapse: collapse;
        }
    </style>


<?php

echo '<table>';
//Affichage de la ligne d'entête:
echo '<tr>';
echo "<th>Id</th>";
echo "<th>Prénoms</th>";
echo "<th>Noms</th>";
echo "<th>Sexe</th>";
echo "<th>Service</th>";
echo "<th>Date_embauche</th>";
echo "<th>Salaire</th>";
echo '</tr>';

//Affichage des lignes
while ($employe = $resultat->fetch(PDO::FETCH_ASSOC)) {// à chaque tour de boucle while, fetch()
    // va chercher la ligne suivante qui correspond à 1 employé et retourne ses informations
    // sous forme de tableau associatif. comme il s'agit d'un tableau, nous faisons ensuite
    // une boucle foreach pour le parcourir
    echo '<tr>';
    foreach ($employe as $value) {// foreach parcourt les données de l'employé

        echo "<td>" . $value . "</td>";

    }
    echo '</tr>';
}


echo '</table>';

//------------------------------
echo '<h2>Requêtes préparées</h2>';
//------------------------------
// Les requêtes préparées sont préconisées si vous éxecutez plusieurs fois la même requête et
// ainsi éviter de répéter le cycle complet analyse/interprétation/exécution réalisé par le SGBD
// (gain de performance).
//les requêtes préparées sont aussi utilisées pour assainir les données
//(se prémunir des injections SQL) =>chapitre ultérieur

$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom ");// prepare() permet de préparer la requête
//mais ne l'execute pas. :nom est un marqueur nominatif qui est vide et attend une valeur

//2_ on lie le marqueur à sa valeur :
$resultat->bindParam(':nom', $nom);// bindparam() lie le marqueur :nom à la variable $nom. remarque: cette méthode recoit exclusivement une variable en second argument. on ne peut pas y mettre une valeur directement

$resultat->bindValue(':nom', 'Sennard');// bindValue() lie le marqueur :nom à la valeur 'Sennard'. contrzirement à bindParam(), bindValue() recoit au choix une variable ou une valeur.

//3_on execute la requête:
$resultat->execute();

debug($resultat);

$employe = $resultat->fetch(PDO::FETCH_ASSOC);
echo $employe['prenom'] . ' ' . $employe['nom'] . ' du service ' . $employe['service'] . '<br>';

/*
 * Valeurs de retour:
 * prepare() retourne toujours un objet PDOstatement
 * execute() :
 * succés: true
 * echec : false
 */
//------------------------------
echo '<h2>Requêtes préparées  points complémentaires </h2>';
//------------------------------

echo '<h3>Le marqueur sous forme de "?"</h3>';
$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom=? AND prenom=? ");
//on prépare la requête avec les parties variables représentées avec des marqueurs sous forme de "?"
$resultat->bindValue(1, 'Durand');
$resultat->bindValue(2, 'Damien');
$resultat->execute();

// OU encore directement dans le execute() :
$resultat->execute(array('Durand', 'Damien'));

/*
 * La flèche -> caractérise les objets: $objet_>methode();
 * les crochets [] caractérisent les tableaux : $tableau['indice'];
 */
$employe = $resultat->fetch(PDO::FETCH_ASSOC);
echo 'Le service est ' . $employe['service'] . '<br>';

//-----------------------------
echo '<h3>Lier les marqueurs nominatifs à leur valeur directement dans execute()</h3>';
$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom=:nom AND prenom=:prenom");
$resultat->execute(array(':nom' => 'chevel', ':prenom' => 'daniel'));
// on associe chaque marqueur à sa valeur directement dans un tableau. Note : nous ne sommes pas obligés de remettre ":"
//devant les marqueurs dans ce tableau
$employe = $resultat->fetch(PDO::FETCH_ASSOC);
echo 'Le service est ' . $employe['service'] . '<br>';

//********************************************** FIN *******************************************

