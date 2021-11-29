<h1>Les commerciaux et leur salaire</h1>

<?php
// Exercice :
// 1- affichez dans une liste <ul><li> le prénom, le nom et le salaire des commerciaux (1 commercial par <li>). Pour cela, vous faites une requête préparée.
// 2- Affichez le nombre de commerciaux.
function debug($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}
$pdo = new PDO('mysql:host=localhost;dbname=entreprise',
    'root',
    '',
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    )
);
$resultat = $pdo->prepare("SELECT * FROM employes WHERE service = :service ");
//$resultat->bindParam(':service', $service);
$resultat->bindValue(':service', 'commercial');
$resultat->execute();
debug($resultat);
$employes= $resultat->fetchAll(PDO::FETCH_ASSOC);
    debug($employes);
    echo '<ul>';
    foreach ($employes as $employe){

        echo "<li>".$employe['prenom']. ' '.$employe['nom'].' '.$employe['salaire'].' €</li>';
    }
    echo '</ul>';

echo "Nombre d'employes au service commercial est : " . $resultat->rowCount() . '<br>';


