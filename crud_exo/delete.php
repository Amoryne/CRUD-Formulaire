<?php

//On demarre une session
session_start();

//EST CE QUE LID EXISTE ET NEST PAS VIDE DANS URL

if(isset($_GET['id']) && !empty($_GET['id'])){
    //ON SE CONNECTE
    require_once('connect.php');
    
    //on nettoie l'id ENVOYER
    $id= strip_tags($_GET['id']);

    //ON DECLARE LA REQUETE
    $sql = "DELETE FROM `liste` WHERE `id`=:id;";

    //ON PREPARE LA REQUETE CONTENUE DANS LA VARIABLE SQL
    $query = $db->prepare($sql);

    //ON Accroche LES PARAMAETRES (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    
    //ON EXECUTE LA REQUETE
    $query->execute();
    $_SESSION['supprimer'] = "Produit supprimé";
    
    //ON REDIRIGE VERS LA PAGE ACCEUIL
    header('Location: index.php');

}
require_once('close.php');

?>