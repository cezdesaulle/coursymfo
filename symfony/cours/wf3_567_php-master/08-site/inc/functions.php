<?php
function debug($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

//-----------------------
// Fonction qui indique si l'internaute est connecté
function estConnecte(){
if (isset($_SESSION['membre'])){ // si "membre" existe dans la session, c'est que l'internaute est passé
    // par la page de connexion avec les bons pseudo/mdp
    return true; // il est connecté
}else{
    return false;//il n'est pas connecté
}
}

//fonction qui indique si le membre connecté est administrateur
function estAdmin(){// si le membre est connecté on regarde son statut dans la session. s'il vaut 1 alors il est bien admin
    if (estConnecte() && $_SESSION['membre']['statut'] == 1){
        return true;
    }else{
        return false;
    }
}

//----------------------------------------------
// fonction qui éxecute les requêtes

function executeRequete($requete, $param = array()){// le paramètre $requete recoit une requête SQL. Le paramètre $param recoit un tableau avec les marqueurs associés à leur valeur.Dans le cas où ce tableau n'est pas fourni, $param prend un array() vide par défaut.

    // Echappement des données avec htmlspecialchars():
    foreach ($param as $indice =>$valeur){
        $param[$indice]= htmlspecialchars($valeur); //on prend la valeur de $param que l'on passe dans htmlspecialchars() pour transformer les chevrons en entité html qui neutralisent les balises <style> et <script> éventuellements injectées dans le formulaire. evite ainsi les risques xss et css


    }

    global $pdo; // permet d'accéder à la variable $pdo qui est dans init.php
    $resultat=$pdo->prepare($requete);// on prépare la requête reçu dans $requete
    $succes = $resultat->execute($param);// puis on l'éxecute en lui donnant le tableau qui associe les marqueurs à leur valeur

    //var_dump($succes);// execute() renvoie toujours un booléen : true quand la requête a marché sinon false

    if($succes){
        return $resultat;
    }else{
        return false;
    }
}

//---------
// fonction qui calcule le TOTAL du panier
function montantTotal(){
    $total=0;

    for ($i=0; $i<count($_SESSION['panier']['id_produit']);$i++){
        $total+=$_SESSION['panier']['quantite'][$i]*$_SESSION['panier']['prix'][$i];
        // on multiplie la quantité par le prix à chaque tour de boucle que l'on ajoute dans $total avec += pour ne pas écraser la dernière valeur
    }
    return $total;

}