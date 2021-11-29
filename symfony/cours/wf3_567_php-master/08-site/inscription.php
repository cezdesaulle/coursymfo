<?php
require_once 'inc/init.php';
$affiche_formulaire = true; //pour afficher le formulaire si l'internaute n'est pas connecté
//debug($_POST);

if (!empty($_POST)){
if (!isset($_POST['pseudo'])  || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo'])>20){
    $contenu.="<div class='alert alert-danger'>Le pseudo doit être compris entre 4 et 20 caractères.</div>";

}
    if (!isset($_POST['nom'])  || strlen($_POST['nom']) < 1 || strlen($_POST['nom'])>20){
        $contenu.="<div class='alert alert-danger'>Le nom doit être compris entre 1 et 20 caractères.</div>";

    }
    if (!isset($_POST['prenom'])  || strlen($_POST['prenom']) < 1 || strlen($_POST['prenom'])>20){
        $contenu.="<div class='alert alert-danger'>Le prenom doit être compris entre 1 et 20 caractères.</div>";

    }
    if (!isset($_POST['mdp'])  || strlen($_POST['mdp']) < 4 || strlen($_POST['mdp'])>20){
        $contenu.="<div class='alert alert-danger'>Le mot de passe doit être compris entre 4 et 20 caractères.</div>";

    }

    if (!isset($_POST['email'])  || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) || strlen($_POST['email']>50)){
        $contenu.="<div class='alert alert-danger'>L'Email n'est pas valide</div>";

    }
    if (!isset($_POST['ville'])  || strlen($_POST['ville']) < 1 || strlen($_POST['ville'])>20){
        $contenu.="<div class='alert alert-danger'>La ville doit être comprise entre 1 et 20 caractères.</div>";

    }
    if (!isset($_POST['civilite'])  || $_POST['civilite']!='m' && $_POST['civilite']!='f'){
        $contenu.="<div class='alert alert-danger'>La civilité doit être sélectionné</div>";

    }
    if (!isset($_POST['code_postal'])  || !preg_match('#^[0-9]{5}$#',$_POST['code_postal'])){
        $contenu.="<div class='alert alert-danger'>Le code postal n'est pas valide.</div>";

    }

    //-------------------------------------
    //S'il n'y a plus d'erreur sur le formulaire, on vérifie si le pseudo existe ou pas avant d'inscrire l'internaute en BDD:
    if (empty($contenu)){// si la variable est vide, c'est qu'il n'y a pas de message d'erreur
        // on vérifie le pseudo en BDD :
        $resultat=executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo'=>$_POST['pseudo']));

        if ($resultat->rowCount()>0){
            $contenu .='<div class="alert alert-danger">Pseudo indisponible. Veuillez en choisir un autre.</div>';

        }else{
            //..................................................
            $mdp= password_hash($_POST['mdp'], PASSWORD_DEFAULT);//nous hachons le mdp avec l'algorithme bcrypt par défaut qui nous retourne une clé de hachage.nous allons l'insérer en BDD
            //debug($mdp);
            $succes=executeRequete(
            "INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse, :statut)", array(
                    ':pseudo'=>$_POST['pseudo'],
                    ':mdp'=>$mdp, // on prend le mdp haché
                    ':nom'=>$_POST['nom'],
                    ':prenom'=>$_POST['prenom'],
                    ':email'=>$_POST['email'],
                    ':civilite'=>$_POST['civilite'],
                    ':ville'=>$_POST['ville'],
                    ':code_postal'=>$_POST['code_postal'],
                    ':adresse'=>$_POST['adresse'],
                    ':statut'=> 0 // 0 pour un membre non admin
                )
            );

            $contenu .='<div class="alert alert-success">Vous êtes inscrit.<a href="connexion.php">Cliquez ici pour vous connecter.</a></div>';
            $affiche_formulaire=false; // pour ne plus afficher le formulaire d'inscription
        }


    }




}

require_once 'inc/header.php';
?>
    <h1 class="mt-4">Inscription</h1>
<?php
echo $contenu; //pour les messages à l'internaute

if ($affiche_formulaire) : // syntaxe en if() : endif; ou le ":" correspond à l'accolade ouvrante et le endif à la fermante
//si le membre n'est pas inscrit, on lui affiche le formulaire

    ?>
    <form action="" method="post">

        <div><label for="pseudo">Pseudo</label></div>
        <div><input type="text" id="pseudo" name="pseudo" value="<?php echo $_POST['pseudo'] ?? '';?>"></div>

        <div><label for="mdp">Mot de passe</label></div>
        <div><input type="password" id="mdp" name="mdp" value="<?php echo $_POST['mdp'] ?? '';?>"></div>

        <div><label for="nom">Nom</label></div>
        <div><input type="text" id="nom" name="nom" value="<?php echo $_POST['nom'] ?? '';?>"></div>

        <div><label for="prenom">Prenom</label></div>
        <div><input type="text" id="prenom" name="prenom" value="<?php echo $_POST['prenom'] ?? '';?>"></div>

        <div><label for="email">Email</label></div>
        <div><input type="text" id="email" name="email" value="<?php echo $_POST['email'] ?? '';?>"></div>

        <div><label for="">Civilité</label></div>
        <div><input type="radio" name="civilite" value="m" checked>masculin
            <input type="radio" name="civilite" value="f" <?php if (isset($_POST['civilite'])) ?>>féminin</div>

        <div><label for="ville">Ville</label></div>
        <div><input type="text" id="ville" name="ville" value="<?php echo $_POST['ville'] ?? '';?>"></div>

        <div><label for="code_postal">Code postal</label></div>
        <div><input type="text" id="code_postal" name="code_postal" value="<?php echo $_POST['code_postal'] ?? '';?>"></div>

        <div><label for="adresse">Adresse</label></div>
        <div><textarea type="text" id="adresse" name="adresse" cols="30" rows="10"><?php echo $_POST['adresse'] ?? '';?></textarea></div>

        <div><input type="submit" value="s'inscrire" class="btn btn-info"></div>
    </form>

<?php
endif;
require_once 'inc/footer.php';