<?php
//--------------------------------------------------
//        Cas pratique : formulaire pour poster des commentaires
//--------------------------------------------------
// Objectif : protéger la requête SQL dont les données viennent de l'internaute.

/*
 * Création de la BDD
 * nom BDD : dialogue
 * Table : commentaire
 * Champs : id_commentaire INT PK AI
 *          pseudo VARCHAR(50)
 *          message TEXT
 *          date_enregistrement DATETIME
 */

function debug($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

// 2- conection à la BDD et traitement de $_POST
$pdo = new PDO('mysql:host=localhost;dbname=dialogue',
    'root',
    '',
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    )
);

if (!empty($_POST)) {
    //5. Traitement contre les failles xss (javascript) et les failles CSS:
    //on parle d'échapper les données.
    // Pour l'exemple on injecte ce css : <style>body{display:none;}</style>

    // Pour s'en prémunir, nous faisons :
    $_POST['pseudo'] = htmlspecialchars($_POST['pseudo'], ENT_QUOTES);
    $_POST['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);
    //cette fonction prédéfinie convertit les caractêres spéciaux (<,>, et les "")
    // en entités HTML (le < devient &lt; le > devient &gt; les guillemets deviennent &quot; etc..).

    // Nous insérons le message en BDD avec une requete qui n'est pas protégée contre les injections et qui n'accepte pas les apostrophes:
    //$resultat = $pdo->query("INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES ('$_POST[pseudo]',NOW(),'$_POST[message]')");
    //ici on insère directement des données dans la requête des données qui viennent d'un formulaire sans avoir

    //4. Nous faisons l'injection SQL suivante  '); DELETE FROM commentaire;#
    // Cette injection a pour effet de VIDER la table.

    // Pour s'en prémunir, nous faisons la requete préparée suivante (en commentant la requete precedente) :
    $resultat = $pdo->prepare("INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES (:pseudo, NOW(), :message)");

    $resultat->execute(array(
        ':pseudo' => $_POST['pseudo'],
        ':message' => $_POST['message']
    ));

//avec la requête préparé, on constate que l'injection SQL est neutralisée. Par ailleurs, on peut mettre
// des apostrophes dans le formulaire.
    //comment ca marche ? Le fait de mettre des marqueurs dans la requête évite que les instructions
    // SQL d'origine et injectées se concatènent. Ces instructions ne s'éxécutent donc plus ensemble.
    // En liant les marqueurs vides à leurs valeur dans execute(), les instructions SQL injectées sont
    // neutralisées par cette méthode qui les rends innofenssives. La BDD ne les exécutes donc pas.


}//fin du if(!empty($_POST))

debug($_POST);
?>
    <h1>Votre message</h1>
    <form action="" method="post">
        <div><label for="pseudo">Pseudo</label></div>
        <div><input type="text" name="pseudo" value="<?php echo $_POST['pseudo'] ?? ''; ?>" id="pseudo"></div>

        <div><label for="message">message</label></div>
        <textarea name="message" id="message" cols="30" rows="10"><?php echo $_POST['message'] ?? ''; ?></textarea>

        <div><input type="submit"></div>
    </form>

<?php
// 3_ Affichage des commentaire
$resultat = $pdo->query("SELECT pseudo, message, DATE_FORMAT(date_enregistrement, '%d/%m/%Y') AS datefr, DATE_FORMAT(date_enregistrement,'%H-%i-%s') AS heurefr FROM commentaire ORDER BY date_enregistrement DESC");
// DATE_FORMAT() en SQL permet de reformater une date et l'heure

echo '<h2>' . $resultat->rowCount() . ' commentaires</h2>';

while ($commentaire = $resultat->fetch(PDO::FETCH_ASSOC)) {
    //print_r($commentaire);// on retrouve les alias de la requête sous forme d'indices dans le tableau $commentaire

    echo '<div>Par ' . $commentaire['pseudo'] . ' le ' . $commentaire['datefr'] . ' à ' . $commentaire['heurefr'] . '</div>';

    echo '<div>' . $commentaire['message'] . '</div><hr>';
}