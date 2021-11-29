<?php
require_once '../inc/init.php';
// ----------------------------------TRAITEMENT PHP----------------------------------------
//  1- restriction d'accès aux admin
if (!estAdmin()) {// si membre non admin ou non connecté, on le renvoie vers connexion.php
    header('location:../connexion.php');
    exit();
}

// 4- Enregistrement du formulaire

//debug($_POST);

if (!empty($_POST)){ // si le formulaire a été envoyé

    // ici il faudrait mettre tous les contrôles sur le formulaire...

    $photo_bdd= ''; // par défaut la photo en BDD est vide
    if (isset($_POST['photo_actuelle'])){ //si il existe photo_actuelle dans $_POST c'est que nous sommes entrain de modifier le produit avec sa photo. On remet l'URL de la photo en BDD
        $photo_bdd=$_POST['photo_actuelle'];


    }

    // 5- suite : traitement de la photo :
    //debug($_FILES); // $_FILES est une superglobale qui représente l'input type 'file' d'un formulaire.
    // L'indice "photo" correspondand à l'attribut "name" de l'input. les autres indices du sous tableau sont prédéfinis:
    // name pour le nom du fichier, type pour le type du fichier, tmp_name pour l'adresse du fichier temporaire en cours d'upload,
    // error pour le code erreur de telechargement, size pour la la taille du fichier uploade


    if (!empty($_FILES['photo']['name'])){ // si un fichier est en cours d'upload
        $fichier_photo=$_FILES['photo']['name'];

        $photo_bdd= 'photo/'.$fichier_photo; // chemin relatif de la photo qui est enregistré en BDD et qui nous servira pour l'attribut "src"
        // des balises images (les photos sont copiées dans le dossier "photo" ligne suivante

        copy($_FILES['photo']['tmp_name'],'../'.$photo_bdd); // cette fonction predefini



    }
    // Insertion en BDD :
    $requete = executeRequete("REPLACE INTO produit VALUES (:id_produit, :reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)", array(
        ':id_produit' => $_POST['id_produit'],
        ':reference' => $_POST['reference'],
        ':categorie' => $_POST['categorie'],
        ':titre' => $_POST['titre'],
        ':description' => $_POST['description'],
        ':couleur' => $_POST['couleur'],
        ':taille' => $_POST['taille'],
        ':public' => $_POST['public'],
        ':photo'=>$photo_bdd,
        ':prix' => $_POST['prix'],
        'stock' => $_POST['stock'],

    ));

if ($requete){ // si executeRequete a retourné un objet PDOStatement donc implicitement évalué à true, alors c'est que la requête a marché
    $contenu.='<div class="alert alert-success">Le produit a été enregistré.</div>';

}else{
    $contenu.='<div class="alert alert-danger">Erreur lors de l\'enregistrement.</div>';
}
    header('location:gestion_boutique.php');
}

//8- Remplissage du formulaire de modification
//debug($_GET);
if (isset($_GET['id_produit'])){
    $resultat= executeRequete("SELECT * FROM produit WHERE id_produit=:id_produit",array(':id_produit' => $_GET['id_produit']));
    $produit=$resultat->fetch(PDO::FETCH_ASSOC);

   // debug($produit);
}




//--------------------------------AFFICHAGE----------------------------------------------
require_once '../inc/header.php';

// 2- liens de navigation
?>
    <h1 class="mt-4">Gestion boutique</h1>

    <ul class="nav nav-tabs">
        <li><a href="gestion_boutique.php" class="nav-link">Affichage des produits</a></li>
        <li><a href="formulaire_produit.php" class="nav-link active">Formulaire produit</a></li>
    </ul>





<?php
echo $contenu;
// 3-formulaire d'ajout ou de modification de produit
?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_produit" value="<?php echo $produit['id_produit']?? 0;?>"> <!--nous mettons 0 par defaut pour que le replace se comporte comme un insert et insère le produit en BDD-->
        <div><label for="reference">Référence</label></div>
        <div><input type="text" name="reference" id="reference" value="<?php echo $produit['reference']?? '';?>"></div>

        <div><label for="categorie">Catégorie</label></div>
        <div><input type="text" name="categorie" id="categorie" value="<?php echo $produit['categorie']?? '';?>"></div>

        <div><label for="titre">Titre</label></div>
        <div><input type="text" name="titre" id="titre" value="<?php echo $produit['titre']?? '';?>"></div>

        <div><label for="description">Description</label></div>
        <div><textarea name="description"  id="description" cols="30" rows="10"><?php echo $produit['description']?? '';?></textarea></div>

        <div><label for="couleur">Couleur</label></div>
        <div><input type="text" name="couleur" id="couleur" value="<?php echo $produit['couleur']?? '';?>"></div>

        <div><label for="taile">Taille</label></div>
        <div><select name="taille" id="taile">
                <option value="S"  <?php if (isset($produit['taille']) && $produit['taille']=='S') echo 'selected';?>>S</option>
                <option value="M" <?php if (isset($produit['taille']) && $produit['taille']=='M') echo 'selected';?>>M</option>
                <option value="L" <?php if (isset($produit['taille']) && $produit['taille']=='L') echo 'selected';?>>L</option>
                <option value="XL" <?php if (isset($produit['taille']) && $produit['taille']=='XL') echo 'selected';?>>XL</option>
            </select></div>

        <div><label for="public">public</label></div>
        <div>
            <input type="radio" name="public" value="m" <?php if (isset($produit['public']) && $produit['public']=='m') echo 'checked';?>>Masculin
            <input type="radio" name="public" value="f" <?php if (isset($produit['public']) && $produit['public']=='f') echo 'checked';?>>Féminin
            <input type="radio" name="public" value="mixte" <?php if (isset($produit['public']) && $produit['public']=='mixte') echo 'checked';?>>Mixte
        </div>

        <div><label for="photo">Photo</label></div>
        <!-- 5-UPLOAD de photo -->
        <div><input type="file" id="photo" name="photo"></div>
        <!-- 9- modif de la photo -->
        <?php
        if(isset($produit['photo'])){// si nous sommes en train de modifier le produit, nous affichons la photo actuellement en BDD
            echo '<p>Photo actuelle du produit</p>';
            echo '<img src="../'.$produit['photo'].'" style="width:90px">';
            echo '<input type="hidden" name="photo_actuelle" value="'. $produit['photo'].'">';
        }
        ?>
        <div><label for="prix">Prix</label></div>
        <div><input type="text" name="prix" id="prix" value="<?php echo $produit['prix']?? '';?>"></div>

        <div><label for="stock">Stock</label></div>
        <div><input type="text" name="stock" id="stock" value="<?php echo $produit['stock']?? '';?>"></div>

        <div><input type="submit" value="Enregistrer" class="btn btn-info mt-2"></div>
    </form>

<?php
require_once '../inc/footer.php';
