<?php
/*
 *
 *
 *
   1- Vous affichez le détail complet du contact demandé, y compris la photo. Si le contact n'existe pas, vous laissez un message. 

*/
$contenu='';
$pdo = new PDO('mysql:host=localhost;dbname=repertoire',
    'root',
    '',
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    )
);



if (!empty($_GET)){

$req=$pdo->prepare("SELECT * FROM contact WHERE id_contact=:id_contact ");

$req->execute(array(':id_contact' => $_GET['id_contact']));
$contact = $req ->fetch(PDO::FETCH_ASSOC);

$contenu.='<div class="card mt-4 mb-4" style="width: 100%;">';
    $contenu.='<h5>Nom: '. $contact['nom'].  '<br>Prénom: '.$contact['prenom'].'</h5>
    <img src="'.$contact['photo'].'" class="card-img-top" alt="...">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Télephone : '. $contact['telephone'].'</li>
            <li class="list-group-item">Email : '. $contact['email'].'</li>
            <li class="list-group-item">Type de contact : '.$contact['type_contact'].'</li>';
        $contenu.='</ul>
</div>';


}else{
    $contenu.='<div class="alert alert-danger">Vous devez sélectionner un contact dans liste des contacts</div>';
}

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Detail contact</title>
</head>
<body>
<div class="container" style="width: 50%">
    <h1 class="text-center" style="font-family: 'Comic Sans MS';color: #0a6ebd">Répertoire Téléphonique</h1>
    <hr>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link " href="ajout_contact.php">Ajout contact</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="detail_contact.php">Détail contact</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="liste_contact.php">Liste des contacts</a>
        </li>
    </ul>
    <h2>Fiche contact</h2>
    <?php  echo $contenu ?>

</div>

























<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
