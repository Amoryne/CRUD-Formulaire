<!-- AFFICHER UN ELEMENT EN DETAIL 
ON SAIT SI ON A UN PRODUIT QUI EXISTE OU PAS ET SI L'url contient ou pas un ID-->

<?php
//ON DEMARRE UNE SESSION
session_start();

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
                <h1>Détails du produit <?= $produit['produit'] ?> </h1>
                <p>ID: <?= $produit['id'] ?> </p>
                <p>Nom: <?= $produit['produit'] ?> </p>
                <p>Prix: <?= $produit['prix'] ?> </p>
                <p>Stock: <?= $produit['nombre'] ?> </p>
                <p>
                    <a href="index.php">Retour</a>
                    <a href="edit.php?id= <?= $produit['id'] ?> ">Modifier</a>
                </p>
            </section>
        </div>
    </main>
</body>
</html>