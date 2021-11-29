<?php
/*
	1- Afficher dans une table HTML la liste des contacts avec tous les champs.
	2- Le champ photo devra afficher la photo du contact en 80px de large.
	3- Ajouter une colonne "Voir" avec un lien sur chaque contact qui amène au détail du contact (detail_contact.php).

*/
$pdo = new PDO('mysql:host=localhost;dbname=repertoire',
    'root',
    '',
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    )
);
$contenu='';
$message='';
if (isset($_GET['id_contact']) && $_GET['action']=='suppress'){// si existe "id_produit dans l'url c'est qu'on a demandé la suppression
    $req=$pdo->prepare("DELETE FROM contact WHERE id_contact = :id_contact");
    $req->execute(array(':id_contact' => $_GET['id_contact']));
    if ($req){
        $message.='<div class="alert alert-success">Le contact a bien été supprimé</div>';

    }else{
        $message.='<div class="alert alert-danger">Erreur lors de la suppression</div>';
    }

}



$req=$pdo->query('SELECT * FROM contact');
while ($contacts = $req->fetch(PDO::FETCH_ASSOC)){
    $contenu.= '<tr>';
//print_r($contacts['photo']);
    foreach ($contacts as $indice=>$info) {// foreach parcourt les données de l'employé
        if ($indice == 'photo'){
            $contenu .= "<td><img class='img-fluid'  src='" . $info . "' alt=''>";
        }elseif ($indice =='email' && strlen($contacts['email'])>20){
            $contenu.= "<td>" . substr($info,0,17) . "...</td>";

        }else{
            $contenu.= "<td>" . $info . "</td>";
        }
    }
    $contenu .='<td>
        <a style="color: black" href="detail_contact.php?id_contact='.$contacts['id_contact'].'">voir contact</a>
        <a  href="ajout_contact.php?action=modif&id_contact='.$contacts['id_contact'].'">modifier contact</a>
        <a style="color: red" onclick="return(confirm(\'Etes vous sûr de vouloir supprimer ce produit?\'))" href="?action=suppress&id_contact='.$contacts['id_contact'].'">supprimer contact</a>
        </td>';
    $contenu.= '</tr>';

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

    <title>Liste contact</title>
</head>
<body>
<div class="container" style="width: 50%;">
    <h1 class="text-center" style="font-family: 'Comic Sans MS';color: #0a6ebd">Répertoire Téléphonique</h1>
    <hr>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link " href="ajout_contact.php">Ajout contact</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="detail_contact.php">Détail contact</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="liste_contact.php">Liste des contacts</a>
    </li>
</ul>

<?php echo $message;?>

    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">id</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Téléphone</th>
            <th scope="col">Email</th>
            <th scope="col">Type de contact</th>
            <th scope="col">Photo</th>
            <th scope="col">voir</th>
        </tr>
        </thead>
        <tbody>
       <?php echo $contenu ?>
        </tbody>
    </table>









</div>




<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
