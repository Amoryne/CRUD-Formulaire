<!-- EXECUTER REQUETE SQL -->

<?php
//ON DEMARRE UNE SESSION
session_start();

//ON INCLU LA CONNEXION VERS LE FICHIER CONNECT
require_once('connect.php');

//ON ECRIT NOTRE REQUETE
$sql = 'SELECT * FROM `liste`';

//ON PREPARE LA REQUETE
$query = $db->prepare($sql);

//ON EXECUTE LA REQUETE
$query->execute();

//ON STOCK LE RESULTAT DANS UN TABLEAU ASSOCIATIF
$result = $query->fetchAll(PDO::FETCH_ASSOC);

//ON FERME LA REQUETE CONNEXION VERS FICHIER CLOSE
require_once('close.php');
?>

<!-- //ON AFFICHE LES DATA SOUS FORME DE TABLE -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</head>
<body>
<main class="container">
   <div class="rom">
       <section class="col-12">

 
<?php
//MESSAGE DALTERT CAR L'id n'existe pas
if(!empty($_SESSION['erreur'])){
    echo    '<div class="alert alert-danger" role="alert">
            '. $_SESSION['erreur'].'
            </div>';
    $_SESSION['erreur'] = "";
}
?>

<?php
//MESSAGE ALERT NOUVEAU PRODUIT AJOUTE
if(!empty($_SESSION['message'])){
    echo    '<div class="alert alert-success" role="alert">
            '. $_SESSION['message'].'
            </div>';
    $_SESSION['message'] = "";
}
?>

<div class"lf></div>
<?php
//MESSAGE ALERT PRODUIT SUPPRIMER
if(!empty($_SESSION['supprimer'])){
    echo    '<div class="alert alert-warning" role="alert">
            '. $_SESSION['supprimer'].'
            </div>';
    $_SESSION['supprimer'] = "";
}
?>




    <table class="table">
        <thead>
            <th>ID</th>
            <th>Actif</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Actions</th>
             </thead>
        <tbody>
            <?php
                foreach($result as $produit){ ?>
                    <tr>
                <td> <?= $produit['id'] ?> </td>
                <td> <?= $produit['actif'] ?> </td>
                <td> <?= $produit['produit'] ?> </td>
                <td> <?= $produit['prix'] ?> </td>
                <td> <?= $produit['nombre'] ?> </td>
                <td>
            <a href="disable.php?id=<?= $produit["id"] ?>">A/D</a>
            <a href="details.php?id=<?= $produit["id"] ?>">Voir</a>
            <a href="edit.php?id=<?= $produit['id'] ?>">Modifier</a>
            <a href="delete.php?id=<?= $produit['id'] ?>">Supprimer</a>
            </td>
            <?php 
                    } 
            ?>
                    </tr>
        </tbody>
    </table>
    <a href="add.php">Ajouter</a>  


</section>
</div>

</main>
</body>
</html>


