<?php
require_once '../inc/init.php';
// ----------------------------------TRAITEMENT PHP----------------------------------------
//  1- restriction d'accès aux admin
if (!estAdmin()){// si membre non admin ou non connecté, on le renvoie vers connexion.php
    header('location:../connexion.php');
    exit();

}
// 7- Suppression du produit
//On se positionne avant l'affichage du table pour que celui ci soit à jour sans le produit supprimé
if (isset($_GET['id_produit'])){// si existe "id_produit dans l'url c'est qu'on a demandé la suppression
    $resultat=executeRequete("DELETE FROM produit WHERE id_produit = :id_produit", array(':id_produit'=>$_GET['id_produit']));
    if ($resultat){// si le DELETE retourne un objet PDOstatement évalué à true cest que la requête a marché
        $contenu.='<div class="alert alert-success">Le produit a bien été supprimé</div>';

    }else{
        $contenu.='<div class="alert alert-danger">Erreur lors de la suppression</div>';
    }

}


// 6- Affichage des produits en back-office

$resultat = executeRequete("SELECT * FROM produit");
$contenu.='<p>Nombre de produits dans la boutique: '. $resultat->rowCount().'</p>';

$contenu .= '<table class="table">';
$contenu.='<tr>';
$contenu.='<th>ID </th>';
$contenu.='<th>Référence </th>';
$contenu.='<th>Catégorie </th>';
$contenu.='<th>Titre </th>';
$contenu.='<th>Description </th>';
$contenu.='<th>Couleur </th>';
$contenu.='<th>Taille </th>';
$contenu.='<th>Public </th>';
$contenu.='<th>Photo </th>';
$contenu.='<th> Prix</th>';
$contenu.='<th> Stock</th>';
$contenu.='<th> Action</th>';
$contenu.='</tr>';
while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {// à chaque tour de boucle while, fetch()
    // va chercher la ligne suivante qui correspond à 1 employé et retourne ses informations
    // sous forme de tableau associatif. comme il s'agit d'un tableau, nous faisons ensuite
    // une boucle foreach pour le parcourir
    //debug($produit);
    $contenu .= '<tr>';
    foreach ($produit as $indice=>$info) {// foreach parcourt les données de l'employé
        if ($indice=='photo') {
            $contenu .= "<td><img style='width: 90px' src='../" . $info . "' alt=''>";
        } else {
            $contenu .= "<td>" . $info . "</td>";
        }
    }

    $contenu .='<td>
        <a href="formulaire_produit.php?id_produit='.$produit['id_produit'].'">modifier</a>
        <a onclick="return(confirm(\'Etes vous sûr de vouloir supprimer ce produit?\'))" href="?id_produit='.$produit['id_produit'].'">supprimer</a>
        </td>';
    $contenu .= '</tr>';
}
    
$contenu.='</table>';

//--------------------------------AFFICHAGE----------------------------------------------
require_once '../inc/header.php';

// 2- liens de navigation
?>
<h1 class="mt-4">Gestion boutique</h1>

    <ul class="nav nav-tabs">
        <li><a href="gestion_boutique.php" class="nav-link active">Affichage des produits</a></li>
        <li><a href="formulaire_produit.php" class="nav-link">Formulaire produit</a></li>
    </ul>





<?php
echo $contenu;
require_once '../inc/footer.php';