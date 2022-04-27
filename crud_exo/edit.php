<?php
//ON DEMARRE UNE SESSION
session_start();
//est ce que j'ai quelque chose dans $post
if($_POST){
    //est ce que tous les champs sont définis et pas vide
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['produit']) && !empty($_POST['produit'])
//ON AJOUTE LID POUR AFFICHER LE PRODUIT
    && isset($_POST['prix']) && !empty($_POST['prix']) 
    && isset($_POST['nombre']) && !empty($_POST['nombre'])){
       
//SI LE FORMULAIRE EST COMPLET ON SE CONNECTE
    require_once('connect.php');

//PROTEGER LES CHAMPS DU FORMULAIRE
//ON NETTOIE LES DONNEE DU FORMULAIRE
    $id = strip_tags($_POST['id']);
    $produit = strip_tags($_POST['produit']);
    $prix = strip_tags($_POST['prix']);
    $nombre = strip_tags($_POST['nombre']);

//ON PREPARE LA REQUETE POUR INSERER INPUT DANS DB
    $sql = "UPDATE `liste` SET `produit`=:produit, `prix`=:prix, `nombre`=:nombre WHERE `id`=:id;";

//ON PREPARE LA REQUETE
    $query=$db->prepare($sql);

//ON ASSIGNE DES PARAMETRES
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->bindValue(':produit', $produit, PDO::PARAM_STR);
    $query->bindValue(':prix', $prix, PDO::PARAM_STR);
    $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);

    $query->execute();

    //MESSAGE SESSION
    $_SESSION['message'] = "Produit modifié";
    
//ON se deconnecte à la fin
    require_once('close.php');  

//NE MARCHE PAS SI MESSAGE OU ECHO AVANT
    header('Location: index.php'); 

    }else {
$_SESSION['erreur']="Le formulaire est incomplet";
    }
}





//VERIFIER SI ON A UN ID et n'est pas vide dans l'url
if(isset($_GET['id']) && !empty($_GET["id"])){
    require_once('connect.php');

    //ON NETTOIE ID ENVOYE
    $id = strip_tags($_GET['id']); //on enleve eventuelle balises html
    $sql = 'SELECT * FROM liste WHERE id= :id;';

    //on prepare la requete
    $query = $db->prepare($sql);

    //on accroche les parametres(id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    //on execute requete
    $query->execute();

    //ON RECUPERE LE PRODUIT
    $produit=$query->fetch();

    //on verifie si le produit existe
    if(!$produit){
        $_SESSION['erreur'] = "Cet ID n'existe pas";
        header('Location: index.php'); 
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php'); //renvoie sur la page d'acceuil
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
            
              <?php

if(!empty($_SESSION['erreur'])){
    echo    '<div class="alert alert-danger" role="alert">
            '. $_SESSION['erreur'].'
            </div>';
    $_SESSION['erreur'] = "";
}
?>
<h1>Modifier un produit</h1>
            <form method="post">
              <div class="form-group">
                <label for="produit">Produit</label>
                <input type="text" id="produit" name="produit" class="form-control" value="<?= $produit['produit'] ?>"]>

            </div>

              <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" step="0.01" id="prix" name="prix" class="form-control" value="<?= $produit['prix'] ?>">
            </div>

              <div class="form-group">
                 <label for="nombre">Stock</label>
                <input type="number" id="nombre" name="nombre" class="form-control" value="<?= $produit['nombre'] ?>">
            </div>
            <br>
            <input type="hidden" value="<?= $id['id'] ?>" name="id">
            <button class="btn btn-primary">Envoyer</button>
            </form>
        </section>
        </div>
    </main>
</body>
</html>