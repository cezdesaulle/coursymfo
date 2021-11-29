<?php
require_once '../inc/init.php';

$contenu.='</table>';
debug($_GET);
debug($_SESSION);
if (isset($_POST['modif'])&& ($_GET['id_membre']!==$_SESSION['membre']['id_membre'])) {
    if ($_GET['statut']==0){
        $req = $pdo->prepare("UPDATE membre SET statut=1 WHERE id_membre = :id");
        $id = $_GET["id_membre"];
        //  debug($id);
        $req->bindParam(':id', $id);
        $req->execute();
    }else {
        $req = $pdo->prepare("UPDATE membre SET statut=0 WHERE id_membre = :id");
        $id = $_GET["id_membre"];
        //  debug($id);
        $req->bindParam(':id', $id);
        $req->execute();
    }
}