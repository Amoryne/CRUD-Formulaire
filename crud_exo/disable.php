//VERIFIER SI ON A UN ID et n'est pas vide dans l'url

<?php
session_start();

if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    //ON NETTOIE ID ENVOYE
    $id = strip_tags($_GET['id']); //on enleve eventuelle balises html
    
    $sql = 'SELECT * FROM `liste` WHERE `id`= :id;';

    //on prepare la requete
    $query = $db->prepare($sql);

    //on accroche les parametres(id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    //on execute requete
    $query->execute();

    //ON VERIFIE QUE LE PRODUIT EST ACTIF AVEC UNE OPERATION TERNAIRE
    $produit=$query->fetch();


//on verifie si le produit existe
    if(!$produit){
        $_SESSION['erreur'] = "Cet ID n'existe pas";
        header('Location: index.php'); 
    }

    //ACTIF OU PAS
    $actif=($produit['actif'] == 0) ? 1 : 0;


    
    
    $sql = 'UPDATE `liste` SET `actif`=:actif WHERE `id`= :id;';
    
    //on prepare la requete
    $query = $db->prepare($sql);

    //on accroche les parametres(id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->bindValue(':actif', $actif, PDO::PARAM_INT);

    //on execute requete
    $query->execute();
    header('Location: index.php');
 
    
} else {
    $_SESSION['erreur'] = "URL invalide";
     //renvoie sur la page d'acceuil
     header('Location: index.php');
 
}

?>