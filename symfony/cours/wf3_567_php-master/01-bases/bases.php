<style>
    h2 {
        border-top: 1px solid navy;
        border-bottom: 1px solid navy;
        color: navy;
    }

    table {
        border: 1px solid black;
        border-collapse: collapse;
    }

    td {
        border: 1px solid black;
        padding: 2PX;
        border-collapse: collapse;
    }

    form.form-example {
        display: table;
    }

    div.form-example {
        display: table-row;
    }

    label, input {
        display: table-cell;
        margin-bottom: 10px;
    }

    label {
        padding-right: 10px;
    }

</style>


<?php

//----------------------------------
echo '<h2>Les balises PHP </h2>';
//----------------------------------

?>

<?php
// pour ouvir un passage en PHP on utilise la balise precedente (l.18)
// pour fermer un passage en PHP on utilise la balise suivante :
?>

<p>Ici je suis en HTML</p>
<!-- en dehors des balises d'ouverture et de fermeture de PHP, nous pouvont écrire du HTML quand on est dans un fichier
ayant PHP. -->

<?php
// vous n'êtes pas obligé de fermer  un passage en PHP en FIN de script

// pour faire 1 ligne de commentaire
#  pour faire 1 ligne de commentaire

/*
 * pour faire des commentaires sur plusieurs lignes
 *
 */

//----------------------------------
echo '<h2>Affichage</h2>';
//----------------------------------

echo 'Bonjour <br>';  // echo permet d'effectuer un affichage dans le navigateur. Nous pouvons y mettre des balises
//HTML sous forme de string. Notez que toutes les instructions se terminent par un ";".

print 'Nous sommes jeudi <br>'; //autre instruction d'affichage dans le navigateur.

//Autres instructions d'affichage que nous verrons plus loin :
print_r('code');
echo '<br>';
var_dump('code');

//----------------------------------
echo '<h2> Variable </h2>';
//----------------------------------
// une variable est un espace mémoire qui porte un nom et qui permet de conserver une valeur.
// en PHP on représente une variable avec le signe "$"

$a = 127; // on déclare la variable a et lui affecte la valeur 127
echo gettype($a);  // gettype() est une fonction prédéfinie qui permet de voir le type d'une variable
// ici il s'agit d'un INTEGER(entier).
echo '<br>';

$a = 1.5;
var_dump($a);
echo gettype($a); // ici nous avons un double = float (nombre à virgule)
echo '<br>';

$a = "une chaine de caractères";
echo gettype($a);
echo '<br>';
$a = '127'; // un nombre écrit dans des quotes ou des guillemets est interprété comme un string


$a = true;
echo gettype($a);
echo '<br>';

// Par convention un nom de variable comence par une minuscule, puis on met une majuscule à chaques mots (camelCase). il peut
// contenir des chiffres (mais jamais au début) ou un _ (pas au debut ni à la fin). Exemple : $maVariable1 ou $ma_variable1

//----------------------------------
echo '<h2> Guillemets et quotes</h2>';
//----------------------------------
$message = "aujourd'hui"; // ou bien :
$message = 'aujourd\'hui'; // on échappe l'appostrophe dans les quotes simples

$prenom = 'john';

echo "bonjour $prenom <br>"; // quand on écrit une variable dans des guillemets, elle est évaluée : c'est son contenu qui
// est affiché. ici "john";
echo 'bonjour $prenom <br>'; // dans des quotes simples, tout est du texte brute

//----------------------------------
echo '<h2>La concaténation </h2>';
//----------------------------------

// En PHP on concatène les éléments avec le point.

$x = 'bonjour ';
$y = 'tout le monde';
echo $x . $y . '<br>'; // Concaténation de variables et d'un string. on peut traduire le point de concaténation par "suivi de...".

//-----------
// Concaténation lors de l'affectation avec l'opérateur .=
$message = '<p>erreur sur l\'email</p>';
$message .= '<p>erreur sur le numero de telephone</p>'; // avec l'opérateur combiné .= on ajoute la première valeur
//sans remplacer la valeur précédente dans la variable $message
echo $message;// on affiche donc les 2 messages.

//----------------------------------
echo '<h2> Constante </h2>';
//----------------------------------
// Une constante permet de conserver une valeur sauf que celle ci ne peut pas changer.c'est à dire qu'on ne pourra pas la
//modifier durant l'éxécution du script utile pour conserver par exemple les paramètres de connexion à la BDD

define('CAPITALE_FRANCE', 'Paris');// définit la constante appelée capitale_france à laquelle on donne la valeur Paris
//Par convention le nom des constantes est toujours en majuscules.
echo CAPITALE_FRANCE . '<br>'; // affiche Paris

// Autre facon de déclarer une constante:
const TAUX_CONVERSION = 6.55957; // définit la constante TAUX_CONVERSION
echo TAUX_CONVERSION . '<br>'; // affiche 6.55957

// Quelques constantes magiques:
echo __DIR__ . '<br>'; // contient le chemin complet vers notre dossier
echo __FILE__ . '<br>'; // contient le chemin complet vers notre fichier


$b = 'Bleu';
$bl = "Blanc";
$r = "Rouge";
$t = "-";

echo $b . $t . $bl . $t . $r . '<br>';
echo $b . '-' . $bl . '-' . $r . '<br>';

//----------------------------------
echo '<h2> Les opérateurs arithmétiques </h2>';
//----------------------------------
$a = 10;
$b = 2;

echo $a + $b . '<br>'; // affiche 12
echo $a - $b . '<br>'; // affiche 8
echo $a * $b . '<br>'; // affiche 20
echo $a / $b . '<br>'; // affiche 5
echo $a % $b . '<br><br><br>'; // affiche 0 car pas de reste à 10/2

//-------
// Les opérateurs arithmétiques combinés :
$a += $b; // equivaut à  $a= $a + $b donc $a=12
echo $a . '<br>';

$a -= $b; // equivaut à  $a= $a - $b donc $a=10
echo $a . '<br>';

$a *= $b; // equivaut à  $a= $a * $b donc $a=20
echo $a . '<br>';

$a /= $b; // equivaut à  $a= $a / $b donc $a=10
echo $a . '<br>';

$a %= $b; // equivaut à  $a= $a % $b donc $=0
echo $a . '<br><br><br>';

//-----
// Incrémenter et décrémenter
$i = 0;
$i++;  // incrémentation de $i par pas de 1 $i=1
$i--;  // décrémentation de $i par pas de 1 $i=0

//----------------------------------
echo '<h2> Les structures conditionnelles </h2>';
//----------------------------------
$a = 10;
$b = 5;
$c = 2;

// if ...else :
if ($a > $b) {
    echo '$a est supérieur à $b <br>';
} else {
    echo 'non $a est inférieur à $b <br>';
}

// L'opérateur AND qui s'écrit && :
if ($a > $b && $b > $c) { // si $a >$b et dans le même temps $b>$c, alors on entre dans les accolades
    echo 'vrai pour les 2 conditions <br>';
}

// TRUE && TRUE => TRUE
// TRUE && FALSE => FALSE
// FALSE && TRUE => FALSE

// L'opérateur OR qui s'écrit ||:

if ($a == 9 || $b > $c) { // si $a ==9 ou dans le même temps $b>$c, alors on entre dans les accolades
    echo 'vrai pour au moins une des 2 conditions <br>';
} else {
    echo 'faux pour les des 2 conditions <br>';
}

// TRUE || TRUE => TRUE
// TRUE || FALSE => TRUE
// FALSE || FALSE => FALSE

//---------------------
// if ... elseif ... else :

if ($a == 8) { // si $a =8
    echo 'rep1: $a=8<br>';
} elseif ($a != 10) { // sinon si $a !=10
    echo 'rep2: $a est différent de 10 <br>';
} else { // si je nentres pas dans le if ni dans le elseif alors $a=10
    echo 'rep3: $a=10<br>';
}

//----------------------
//L'opérateur XOR pour OU exclusif
$question1 = 'je suis mineur';
$question2 = 'je vote'; // exemple d'un questionnaire

// Les réponses de l'internaute n'étant pas cohérentes, on lui met un message :
if ($question1 == 'je suis mineur' xor $question2 == 'jevote') {// XOR= OU exclusif. seulement une des 2 conditions doit être valide
    //pour entrer dans le if si nous avons TRUE XOR TRUE cela donne FALSE
    echo 'vos réponses sont cohérentes<br>';
} else {
    echo 'vos réponses ne sont pas cohérentes<br>';
}


//-------------------
// Forme dite ternaire de la conditon (autre syntace du if):
$a = 10;

echo ($a == 10) ? '$a est egal à 10 <br>' : '$a est différent de 10<br>';
//le ? remplace if et le : remplace else. on affiche le premier string si la condition est vrai sinon le second

//-----------------
// Comparaison == ou ===:
$varA = 1; // integer
$varB = '1'; // string

if ($varA == $varB) { // avec == on compare uniquement la valeur
    echo '$varA est égal à $varB en valeur<br>';
}
if ($varA === $varB) { // avec === on compare la valeur et le type
    echo '$varA est égal à $varB en valeur et en type<br>';
} else {
    echo '$varA et $varB sont différentes en valeur ou en type<br>';
}

//----------
// isset() et empty():
// empty() : vérifie si la variable est vide, c'est à dire 0, "", NULL, FALSE ou non définie
// isset() : vérifie si la variable existe et a une valeur non NULL

$var1 = 0;
$var2 = '';

if (empty($var1)) echo '$var1 contient 0, string vide, NULL, FALSE ou UNDEFINED<br>';
// VRAI car la variable =0

if (isset($var2)) echo 'La Variable existe et est non NULL<br>'; // Vrai car la variable existe et ne contient pas NULL

// Contexte: empty pour vérifier les champs de formulaire, isset pour vérifier l'existence d'un indice dans un tableau avant d'y accéder

//------------------------------------
// L'opérateur NOT qui s'écrit "!":
$var3 = 'quelque chose';
if (!empty($var3)) { // le ! correspond à une négation : il intervertit le sens du booléen : !TRUE devient FALSE !FALSE devient TRUE. ici signifie $var3
    //n'est pas vide
    echo 'La variable n\est pas vide <br>';
}

//---------------------------------
// L'opérateur ?? appelé "NULL coalescent" : (à partir de PHP7)

echo $variable_inconnue ?? 'valeur par défaut<br>';

//----------------------------------
echo '<h2> Switch </h2>';
//----------------------------------
//la condition switch est une autre syntaxe pour écrire un if elseif else quand on veut comparer une variable à une multitude de valeurs.

$langue = 'chinois';

switch ($langue) {
    case 'francais': // on compare $langue à la valeur des "case" et éxécute le code qui suit si elle correspond :
        echo 'Bonjour !';
        break;// obligatoire pour quitter le switch une fois un "case" executé
    case 'italien':
        echo 'Ciao !';
        break;
    case 'espagnol' :
        echo 'Hola!';
        break;
    default :
        echo 'Hello ! <br>'; // cas par défault éxecuté si on n'entre pas dans l'un des "case"
        break;
}

if ($langue == 'francais') {
    echo 'Bonjour !';
} elseif ($langue == 'italien') {
    echo 'Ciao !';
} elseif ($langue == "espagnol") {
    echo 'Hola!';
} else {
    echo 'Hello ! <br>';
}

//----------------------------------
echo '<h2> Fonctions utilisateur </h2>';
//----------------------------------
// Une fonction est un morceau de code encapsulé dans des accolades et qui porte un nom.ON appelle cette fonction au besoin
//pour éxécuter le code qui s'y trouve. Le fait de définir des fonctions pour ne pas se répeter s'appelle "factoriser" son code

//on définit puis on éxecute une fonction:
function separation()
{ // déclaration d'une fonction prévue pour ne pas recevoir d'argument

    echo '<hr>';
}

separation();// on appelle notre fonction par son nom suivie d'une paire de();

//------------------
// Fonction avec paramètres et return:
function bonjour($prenom, $nom)
{ // $prenom et $nom sont des paramètres dela fonction. ils permettent de recevoir une valeur car
    // il s'agit de variable de reception
    return 'bonjour ' . $prenom . ' ' . $nom . ' ! <br>';
    //return renvoie la chaine de caractère "bonjour ...." à l'endroit où la fonction est appelée

    echo 'cette ligne ne sera pas éxécutée'; // car après unreturn on quitte la fonction
}

echo bonjour('john', 'doe');// si la fonction attend des valeurs, il faut les lui envoyer dans le même ordre que les paramètres de réception.
// Les valeurs envoyées s'appellent "arguments". Quand on souhaite afficher le résultat, et qu'il n'y a pas de echo dans la fonction,
// il faut le faire en même temps que l'appel de la fonction.

//-------------------
$prenom = 'Pierre';
$nom = 'Quiroule';
echo bonjour($prenom, $nom); // on peut mettre des variables à la place des valeurs dans l'appel d'une fonction (exemple: quand on voudra recuperer
//les valeurs d'un formulaire).

//--------------------
// Exercice :
// fonction factureEssence() => calcule le cout total de la facture en fonction du nombre de litres d'essence que vous indiqué à l'appel de la
// fonction. elle doit retourner la phrase "votre facture est de X euros pour Y litres d'essences. X et Y sont des variables.Pour cela, on vous donne une
//fonction prixLitre() qui vous retourne le prix du litre

function prixLitre()
{
    return rand(100, 200) / 100;
}

//echo prixLitre();
?>


<form action="" method="get" class="form-example">
    <div class="form-example">
        <label for="name">Entrez le nombre de litre de votre plein: </label>
        <input type="text" value="" name="name" id="name" required>
    </div>
    <div class="form-example">
        <input type="submit" value="Subscribe!">
    </div>
</form>

<?php
function factureEssence($Y)
{
    $l = prixLitre();
    $X = $Y * $l;
    echo "Le prix du litre d'essence étant de " . $l . " euros <br>";
    return "votre facture est de " . $X . " euros pour " . $Y . " litres d'essences";

}

echo factureEssence(rand(50, 150)) . "<br>";

//--------------
// En PHP7 on peut préciser le type des valeurs entrantes dans une fonction:
function identite(string $nom, int $age)
{ // array, bool, float, int, string

    echo gettype($nom) . '<br>';
    echo gettype($age) . '<br>';
    echo $nom . " a " . $age . " ans <br>";
}

identite("asterix", 60); // le type attendu dans la fonction est respecté, il n'y a pas d'erreur
identite("asterix", "60");// ici le traitement a forcé le type string de "60" en integer
//identite('asterix', 'soixante'); //fatel error car on passe un string qui ne peut être transformer en integer on commente donc la ligne
//pour poursuivre

// PHP7 on peut aussi préciser la valeur de retour que doit sortir la fonction:
function adulte(int $age): bool
{ // array, bool, float, int, string

    if ($age >= 18) {
        return true;
    } else {
        return false;
    }

}

var_dump(adulte(7)); // ici la fonction nous retourne bien un booléen, il n'y a donc pas d'erreur. Nous faisons un var_dump
// car il permet d'afficher le false que retourne la fonction, "echo false" n'affichant rien


//------------------------
// Variable locale et variable globale :

// De l'espace local vers l'espace global:
function jourSemaine()
{
    $jour = 'vendredi';// variable locale
    return $jour;
}

//echo $jour; ne fonctionne pas car cette variable n'est connue qu'à l'intérieur de la fonction

echo '<br>';
echo jourSemaine(); // on affiche ce que nous retourne la fonction grace à son return
echo '<br>';
// De l'espace global vers le local:
$pays = 'france';// variable globale
function affichePays()
{
    global $pays;//le mot clé global permet de récuperer une variable globale au sein de l'espace local de la fonction. on peut donc l'afficher
    echo $pays;
}

affichePays();

//----------------------------------
echo '<h2> Structures itératives : les boucles </h2>';
//----------------------------------
//Les boucles sont destinées à répéter des lignes de code de façon automatique

//Boucle While :
$i = 0; // on initialise à 0 une variable qui sert de compteur

while ($i < 3) { // tant que $i est inférieur à 3 nous entrons dans la boucle
    echo $i . '<br>';
    $i++; // on incrémente $i à chaque tour de boucle afin de ne pas avoir une boucle infinie (à la 3 la condition étant fausse, on quitte la boucle)
}

// Exercice : à l'aide d'une boucle while, afficher un sélecteur avec les années depuis 1920 jusqu'à 2020
//
echo '<select>';
$i = 1920;
while ($i <= date("Y")) {
    echo '<option>' . $i . '</option>';
    $i++;
}
echo '</select>';

echo '<br>';

//------------------------------
// La boucle do while:
// La boucle do while a la particularité de s'éxecuter au moins une fois, puis tant que la condition de fin est vraie.

$j = 0;

do {
    echo 'je fais un tour <br>';
    $j++;
} while ($j > 10); // la conditon est false et pour la boucle a tourné 1 fois

echo '<br>';

//-----------------------
// La boucle for :
// La boucle for est une autre syntaxe de la boucle while

for ($i = 0; $i < 3; $i++) { // nous trouvons dans les () de for: la valeur de départ; la condition d'entrée dans la boucle; la variation de $i
    echo $i . "<br>";
}

echo '<select>';
for ($i = 1; $i < 13; $i++) {
    echo '<option>' . $i . '</option>';

}
echo '</select>';

echo '<br>';

//-----------------
// il existe aussi la boucle foreach que nous verrons un peu plus loin.elle sert à parcourir  les tableaux ou les objets.

//-------------------
echo "<table>";
echo "<tr>";
for ($i = 0; $i < 10; $i++) {
    echo "<td>" . $i . "</td>";
}
echo "</tr>";
echo "</table>";

echo '<br>';


echo "<table>";
for ($z = 0; $z < 10; $z++) {
    echo "<tr>";
    for ($i = 0; $i < 10; $i++) {
        echo "<td>" . $i . "</td>";
    }
    echo "</tr>";
}

echo "</table>";

//----------------------------------
echo '<h2> Quelques fonctions prédéfinies </h2>';
//----------------------------------
// Une fonction prédéfinie permet de réaliser un traitement spécifique prédéterminé dans le langage PHP.

// strlen
$phrase = 'mettez une phrase ici';
echo strlen($phrase); // affiche le nombre d'octets occupés pas ce string, 1 caractère accentué comptant pour 2, les autres pour 1.

echo "<br>";
// substr
$texte= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, beatae blanditiis dolore dolores doloribus est 
excepturi harum, hic, illo libero nam necessitatibus nesciunt non omnis quia quis sint voluptates voluptatibus.';
echo substr($texte,0,20).'...<a href="">lire la suite</a>'; // coupe la phrase à 20 caractère

echo "<br>";

// strtolower, strtoupper, trim :
$message = '         Hello World';
echo strtolower($message);// tout en minuscule
echo "<br>";
echo strtoupper($message);// tout en majuscule
echo "<br>";
echo strlen($message);
echo "<br>";
echo strlen(trim($message));// supprime les espaces au debut et à la fin de la chaine de caractère
echo "<br>";

// La documentation PHP en ligne :

//----------------------------------
echo '<h2> Tableaux (array) </h2>';
//----------------------------------
// Un tableau ou encore array en anglais, est déclaré comme une variable ameliorée dans laquelle on stocke une multitude de valeur
//ces valeurs peuvent être de n'importe quel type et possède un indice par défaut dont la nnumérotation commence à 0

// Utilisation : souvent quand on récupère des informations de la BDD, nous les retrouvons sous forme de tableau.

//Déclarer un tableau (méthode 1) :
$liste= array('Grégoire','Nathalie','Emilie','François','Georges');

echo gettype($liste).'<br>';

//echo $liste; erreur 'notice' array to string conversion car on ne peut pas afficher directement un tableau

echo 'var_dump et print_r:';

echo "<pre>";
print_r($liste);// affiche le contenu du tableau sans le type des valeurs
echo "</pre>";//la balise <pre> permet de formater l'affichage du print_r ou du var_dump

echo "<pre>";
var_dump($liste);// affiche le contenu du tableau avec le type des valeurs
echo "</pre>";

//déclaration de notre fonction d'affichage :
function debug($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

debug($liste);

// Autre méthode pour déclarer un tableau (méthode 2):
$tab = ['France','Italie','Espagne','Portugal'];
debug($tab);

echo $tab[1];// pour afficher l'italie, on ecrit le nom du tableau $tab suivi de l'indice de "italie" écrit en []
echo "<br>";

//--------------
// Ajouter une valeur à la fin de notre tableau $tab:
$tab[]='Suissse'; // les [] vides permettent d'ajouter une valeur à la fin du tableau
debug($tab);
echo "<br>";

//-----------
// Tableau associatif :
// Dans un tableau associatif, on peut choisir les indices.
$couleur = array(
        'j'=> 'jaune',
        'b'=> 'bleu',
        'v'=> 'vert'
);
debug($couleur);

// pour afficher un élément du tableau associatif :
echo 'La seconde couleur de notre taleau est le '.$couleur['b'].'<br>';
echo "la seconde couleur est le $couleur[b] <br>";// un tableau assciatif ecrit dans des guillements perd les quotes autour de son indice

//---------------
//Mesurer le nombre d'éléments dans un tableau :

echo 'Taille du tableau:'.count($couleur).'<br>'; //compte le nombre d'élément dans le tableau ici 3.
echo 'Taille du tableau :'.sizeof($couleur).'<br>';// sizeof() fait la même chose que count() dont il est un alias

//----------------------------------
echo '<h2> Boucle foreach </h2>';
//----------------------------------
// foreach est un moyen simple de parcourir un tableau de façon automatique.
//Cette boucle fonctionne uniquement sur les tableaux et les les objets. Elle retourne une erreur si vous l'utilisé sur une variable d'un autre type ou non
//initialisée.

debug($tab);

foreach ($tab as $pays){// la variable $pays vient parcourir la colonne des valeurs: elle prend chaque valeur successivement à chaque tour
    //de boucle. le mot "as" est obligatoire et fait partie de la syntaxe

    echo $pays. '<br>';// affiche successivement les valeurs du tableau
}

foreach ($tab as $indice => $pays){// quand il a 2 variables, celle qui esdt à gauche de la => parcourt la colonne des indices, et celle de droite parcourt
    //la colonne des valeurs
    echo $indice.' correspond à '.$pays. '<br>';
}

// Exercice :
// - Ecrivez un tableau associatif avec les INDICES prenom, nom, email et telephone, auxquels vous associez des valeurs pour 1 contact.
// - Puis avec une boucle foreach, affichez les valeurs dans des <p>, sauf le prénom qui doit être dans un <h3>.


$contact= array(
        'prenom'=>'jonh',
        'nom'=>'doe',
        'email'=>'johndoe@gmail.com',
        'telephone'=>'0142567523'
);


foreach ($contact as $cont){
    if($cont==$contact['prenom']){
        echo"<h3>Bonjour $cont</h3>";
    }else {
        echo "<p>$cont</p>";
    }
}

//----------------------------------
echo '<h2> Tableau multidimensionnel </h2>';
//----------------------------------
// Nous parlons de tableaux multidimensionnels quand un tableau est contenu dans un autre tableau. Chaque tableau représente une dimension.

// Déclaration d'un tableau multidimensionnel :
$tab_multi = array(
    array(
       'prenom'=>'julien',
       'nom'=>'dupond',
       'telephone'=>'0612432775'
    ), array(
        'prenom'=>'nicolas',
        'nom'=>'durand',
        'telephone'=>'0612445576'
    ), array(
        'prenom'=>'pierre',
        'nom'=>'dulac',
    )

);// il est possible de choisir le nom des indices d'un tableau multidimensionnel.
debug($tab_multi);
echo $tab_multi[0]['prenom'].'<br>';// pour afficher "julien" nous entrons d'abord dans le tableau $tab_multi,
// puis nous allons à son indice [0], dans lequel nous allons à l'indice ['prenom'] (les crochets sont successifs)
echo '<hr>';
// Parcourir le tableau multidimensionnel avec une boucle for :
for ($i = 0;$i < sizeof($tab_multi);$i++){
    echo $tab_multi[$i]['prenom'].'<br>';
}
echo '<hr>';

foreach ($tab_multi as $perso){
    echo $perso['prenom'].'<br>';
}
echo '<hr>';

//------
// Exercice (option) : vous déclarez un tableau contenant les tailles S, M, L et XL.
// Puis vous les affichez dans un menu déroulant (select/option) à l'aide d'une boucle foreach.
$vetements = array(
    array(
        'taille'=>'S',

    ), array(
        'taille'=>'M',

    ), array(
        'taille'=>'L'

    ), array(
        'taille'=>'XL'

    )
);

echo "<select>";
foreach($vetements as $vetement){
    echo "<option>".$vetement['taille']."</option>";
}
echo "</select>";

//----------------------------------
echo '<h2> Les inclusions de fichiers </h2>';
//----------------------------------

echo 'Première inclusion :';
include 'exemple.inc.php'; // le fichier est inclus, c'est-à-dire que son code s'exécute ici.En cas d'erreur
// lors de l'inclusion, include génère une erreur de type "warning" et continue l'éxecution du script

echo 'Seconde inclusion:';
include_once 'exemple.inc.php';// le "once" est la pour vérifier si le fichier a déjà était inclus, auquel cas il
//il ne le ré-inclus pas
echo '<br>';
echo"3ème inclusion :";
require 'exemple.inc.php';// le fichier est requis, donc obligatoire : en cas d'erreur lors de l'inclusion
//require génère une "fatal error" qui stoppe l'exécution du code
echo '<br>';
echo "quatrième inclusion:";
require_once 'exemple.inc.php';// le "once" est la pour vérifier si le fichier a déjà était inclus, auquel cas il
//il ne le ré-inclus pas
echo "<br>";
echo "<br>";
echo $inclusion;// comme le fichier exemple.inc.php est inclus, on accède aux variables, fonctions et autres de ce
// fichier...

//La mention "inc" dans le nom du fichier précise au développeurs qu'il s'agit d'un fichier d'inclusion et non pas
// d'une page à part entière

//----------------------------------
echo '<h2> Introduction aux objet </h2>';
//----------------------------------

// Un objet est un autre type de données (object en anglais).
// Il représente un objet réel (par exemple voiture, membre, panier d'achat, produit...)
//auquel on peut associer des variables, appelées POPRIETES et des fonction appelées METHODES.

//Pour créer des objets, il nous faut un "plan de construction": c'est le rôle de la classe.
// Nous créons ici une classe pour faire des objets "meubles" :
class Meuble { // avec une majuscule

   public $marque='ikea'; // $marque est une propriété. "public" précise qu'elle sera accessible partout

    public function prix(){
        return rand(50,200). ' €';
    }

}
//----------------------
$table = new Meuble(); // new est un mot clé qui permet d'instancier la classe our en faire un objet.
//l'intérêt est que notre $table bénéficie de la propriété "ikéa" et de la methode prix() définis dans la classe.

debug($table);// nous observons le type "object", le nom de sa classe "Meuble" et sa propriété "marque".

echo 'Marque du meuble : '.$table->marque.'<br>'; // pour accéder à la propriété d'un objet,
// on écrit cet objet suivi de "->' puis du nom de la propriété dans le $

echo 'Prix du meuble: '.$table->prix().'<br>'; // pour accéder à la méthode d'un objet,
// on l'écrit avec la flèche -> à laquelle on ajoute une paire()


//*****************************     FIN   ******************************