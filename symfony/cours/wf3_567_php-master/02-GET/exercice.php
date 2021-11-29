<?php

echo '<h1>Mon profil</h1>';
echo '<a href="exercice.php?action=modification">Modifier mon profil</a>';
if(isset($_GET['action']) && $_GET['action']=='modification'){
    echo "<p>Vous avez demandé la modification de votre profil</p>";
}


echo '<hr>';
echo '<a href="exercice.php?action=suppression" onclick="return confirm(\'Etes vous sûr?\')">Supprimer mon profil</a>';
if(isset($_GET['action']) && $_GET['action']=='suppression'){
    echo "<p>Votre profil est supprimé</p>";
}

