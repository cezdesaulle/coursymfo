<?php
$pdo = new PDO('mysql:host=localhost;dbname=repertoire',
    'root',
    '',
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    )
);



?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Ajout contact</title>
</head>
<body>
<?php
/* 1- Créer une base de données "repertoire" avec une table "contact" :
	  id_contact PK AI INT
	  nom VARCHAR(50)
	  prenom VARCHAR(50)
	  telephone VARCHAR(10)
	  email VARCHAR(255)
	  type_contact ENUM('ami', 'famille', 'professionnel', 'autre')
	  photo VARCHAR(255)

	2- Créer un formulaire HTML (avec doctype...) afin d'ajouter un contact dans la bdd.
	   Le champ type_contact doit être géré via un "select option".
	   On doit pouvoir uploader une photo par le formulaire.

	3- Effectuer les vérifications nécessaires :
	   Les champs nom et prénom contiennent 2 caractères minimum, le téléphone 10 chiffres
	   Le type de contact doit être conforme à la liste des types de contacts
	   L'email doit être valide
	   En cas d'erreur de saisie, afficher des messages d'erreurs au-dessus du formulaire

	4- Ajouter les infos du contact dans la BDD et afficher un message en cas de succès ou en cas d'échec.
	5- Si une photo est uploadée, ajouter la photo du contact en BDD et uploader le fichier sur le serveur de votre site.

*/
$contenu='';
$id="";


if (!empty($_POST)){
    if (isset($_POST['photo_actuelle'])){ //si il existe photo_actuelle dans $_POST c'est que nous sommes entrain de modifier le produit avec sa photo. On remet l'URL de la photo en BDD
        $photo_bdd=$_POST['photo_actuelle'];

    }


    if (!isset($_POST['nom']) || strlen($_POST['nom'])<2 || strlen($_POST['nom'])>50){
        $contenu.='<div class="alert alert-danger">Le nom doit comporter au moins 2 caractères</div>';
    }
    if (!isset($_POST['prenom']) || strlen($_POST['prenom'])<2 ||  strlen($_POST['prenom'])>50){
        $contenu.='<div class="alert alert-danger">Le prénom doit comporter au moins 2 caractères</div>';
    }
    if (!isset($_POST['telephone']) || strlen($_POST['telephone']<10) || !preg_match('#^[0-9]{10}$#',$_POST['telephone'])){
        $contenu.='<div class="alert alert-danger">Le numéro de téléphone n\'est pas valide</div>';
    }
    if (!isset($_POST['email'])  || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) || strlen($_POST['email']>255)){
        $contenu.="<div class='alert alert-danger'>L'Email n'est pas valide</div>";

    }
    if (!isset($_POST['type_contact']) || ($_POST['type_contact']!='ami' && $_POST['type_contact']!='famille' && $_POST['type_contact']!='professionnel' && $_POST['type_contact']!='autre')){
        $contenu.="<div class='alert alert-danger'>Vous devez sélectionner un type de contact conforme </div>";

    }


    if(empty($contenu)) {
       // print_r($_FILES);
        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['size']>20000 && ($_FILES['photo']['type'] == 'image/png' || $_FILES['photo']['type'] == 'image/jpg')){
            $fichier_photo=$_FILES['photo']['name'];

            $photo_bdd= 'upload/photo/'.$fichier_photo;

            copy($_FILES['photo']['tmp_name'],$photo_bdd);

        }else{
            $photo_bdd='http://placehold.it/70x40';
        }


        $_POST['nom']=htmlspecialchars(($_POST['nom']), ENT_QUOTES);
        $_POST['prenom']=htmlspecialchars(($_POST['prenom']), ENT_QUOTES);
        $_POST['email']=htmlspecialchars(($_POST['email']), ENT_QUOTES);

        $req = $pdo->prepare("REPLACE INTO contact VALUES (:id_contact, :nom, :prenom, :telephone, :email, :type_contact, :photo)");

        $succes=$req->execute(array(
                ':id_contact' => $_POST['id_contact'],
                ':nom' => $_POST['nom'],
                ':prenom' => $_POST['prenom'],
                ':telephone' => $_POST['telephone'],
                ':email' => $_POST['email'],
                ':type_contact' => $_POST['type_contact'],
                ':photo' => $photo_bdd,
            )
        );
        $id=$pdo->lastInsertId();
        print_r($id);

        if ($succes){ // si executeRequete a retourné un objet PDOStatement donc implicitement évalué à true, alors c'est que la requête a marché
            $contenu.='<div class="alert alert-success">Nouveau contact ajouté!</div>';

        }else{
            $contenu.='<div class="alert alert-danger">Erreur lors de l\'enregistrement.</div>';
        }
    }

    header('location:detail_contact.php?id_contact='.$id);
}


if (isset($_GET['id_contact']) && $_GET['action']=='modif') {
    $req = $pdo->prepare("SELECT * FROM contact WHERE id_contact=:id_contact", array(':id_contact' => $_GET['id_contact']));
    $req->execute(array(':id_contact' => $_GET['id_contact']));
    $contact = $req->fetch(PDO::FETCH_ASSOC);

}

//print_r($_POST);
?>
<div class="container" style="width: 50%;">
    <h1 class="text-center" style="font-family: 'Comic Sans MS';color: #0a6ebd">Répertoire Téléphonique</h1>
    <hr>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="ajout_contact.php">Ajout contact</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="detail_contact.php">Détail contact</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="liste_contact.php">Liste des contacts</a>
        </li>
    </ul>
    <h2>Formulaire d'ajout de contact</h2>
    <hr>
    <?php echo $contenu;?>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_contact" value="<?php echo $contact['id_contact']?? 0;?>">
    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $contact['nom']?? '';?>" >
    </div>
    <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $contact['prenom']?? '';?>">
    </div>
    <div class="form-group">
        <label for="telephone">Téléphone</label>
        <input type="text" name="telephone" class="form-control" id="telephone" value="<?php echo $contact['telephone']?? '';?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $contact['email']?? '';?>" placeholder="name@example.com">
    </div>

    <div><label for="type_contact">Type de contact</label></div>
    <select name="type_contact" class="custom-select mr-sm-2" id="type_contact">
        <option value="ami"<?php if (isset($contact['type_contact']) && $contact['type_contact']=='ami') echo 'selected';?>>ami</option>
        <option value="famille"<?php if (isset($contact['type_contact']) && $contact['type_contact']=='famille') echo 'selected';?>>famille</option>
        <option value="professionnel"<?php if (isset($contact['type_contact']) && $contact['type_contact']=='professionnel') echo 'selected';?>>professionnel</option>
        <option value="autre"<?php if (isset($contact['type_contact']) && $contact['type_contact']=='autre') echo 'selected';?>>autre</option>
    </select>

    <div class="form-group">
        <label for="photo">Photo</label>
        <input type="file" name="photo" class="form-control-file" id="photo">
    </div>
    <?php
    if(isset($contact['photo'])){// si nous sommes en train de modifier le produit, nous affichons la photo actuellement en BDD
        echo '<p>Photo actuelle du contact</p>';
        echo '<img src="'.$contact['photo'].'" style="width:90px">';
        echo '<input type="hidden" name="photo_actuelle" value="'. $contact['photo'].'">';
    }
    ?>
    <div class="form-group row mt-4">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </div>
</form>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>

