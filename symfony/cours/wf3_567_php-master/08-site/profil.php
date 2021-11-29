<?php
require_once 'inc/init.php';
/* Exercice :
   1- si le visiteur accède à cette page et qu'il n'est pas connecté, vous le redirigez vers la page de connexion.
   2- Dans cette page, vous affichez toutes les informations de son profil. Par ailleurs vous ajoutez un message
de bienvenue juste après le <h1> : "Bonjour [prenom] [nom] !".
    3- Ajoutez un lien "supprimer mon compte". Quand on clique, vous supprimez le membre en BDD après avoir demandé
confirmation de la suppression en JavaScript. Une fois le profil supprimé, vous détruisez la session et redirigez
le membre vers la page inscription.php.
*/


require_once 'inc/header.php';


//debug($_SESSION);

?>
    <h1 class="mt-4">Profil</h1>
<?php
if(!estConnecte()){
    header('location:connexion.php');// on envoie dans le header du texte HTTP qui transite entre serveur et client le "message" location:connexion.php. Celui-ci spécifie au navigateur qu'il doit demander la page connexion.php
    exit();
}

if (!empty($_SESSION)) {
    echo ' <div class="card" style="width: 18rem;">
        <div class="card-body alert-info">
            <h3 class="card-title"> BONJOUR<br> ' . $_SESSION['membre']['prenom'] . ' ' . $_SESSION['membre']['nom'] . '</h3>';
          if (estAdmin()){
            echo '<h4 class="list-group-item alert alert-danger">Vous êtes administrateur</h4>';
        }
           echo '<h5>Vos informations : </h5>
    </div>
        <ul class="list-group list-group-flush">  
            <li class="list-group-item">Pseudo: ' . $_SESSION['membre']['pseudo'] . '</li>   
            <li class="list-group-item">Nom: ' . $_SESSION['membre']['nom'] . '</li>
            <li class="list-group-item">Prenom: ' . $_SESSION['membre']['prenom'] . '</li>
            <li class="list-group-item">Email: ' . $_SESSION['membre']['email'] . '</li>
            <li class="list-group-item">Civilité: ' . $_SESSION['membre']['civilite'] . '</li>
            <li class="list-group-item">Adresse: ' . $_SESSION['membre']['adresse'] . '</li>
            <li class="list-group-item">code postal: ' . $_SESSION['membre']['code_postal'] . '</li>
            <li class="list-group-item">Ville: ' . $_SESSION['membre']['ville'] . '</li>
        </ul>
   
    </div>';

} //else {
  //  echo '<div class="alert alert-danger">Vous n\'êtes pas connecté, veuillez cliquer sur ce lien: <a href="connexion.php">Connexion</a></div>';
//};
echo '<div class="card-body">
            <form action="" method="post">
            <button class="btn btn-danger" type="submit" name="delete" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer votre profil?\'));">Supprimer mon profil</button>
</form>
        </div>';
//debug($_POST);
if (isset($_POST['delete'])) {
    $req = $pdo->prepare("DELETE FROM membre WHERE id_membre = :id");
    $id = $_SESSION["membre"]["id_membre"];
    //  debug($id);
    $req->bindParam(':id', $id);
    $req->execute();
    session_destroy();
    header('Location: inscription.php');
    exit();
}

/*
 * $id = $_SESSION["membre"]["id_membre"];
 * $req = executeRequete("DELETE FROM membre WHERE id_membre = $id");
 *  session_destroy();
    header('Location: inscription.php');
    exit();
 */

?>


<?php
require_once 'inc/footer.php';