<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: ../index.php');
        exit();
    }

    require_once("../bdd/connect_db.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title> SHOP2MAILLOTS { catalogue } </title>
    <link rel="stylesheet" href="../ressources/css/styles.css">
    <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
</head>
<body>

    <?php require_once("../includes/header.php"); ?>

    <div class="conteneur-catalogue">
        <h1 class="titre-page">NOS MAILLOTS</h1> 

        <?php 

        $result = mysqli_query($con, "SELECT id_maillot, nom_maillot, fichier_image FROM Maillot");

        echo '<div class="grille-produits">';

        while($maillot = mysqli_fetch_array($result)) {
            echo '<div class="carte-produit">';
            
            echo '<img src="../ressources/images/'.$maillot['fichier_image'].'" alt="'.$maillot['nom_maillot'].'" class="image-produit">'; 
            echo '<h3 class="nom-produit">'.$maillot['nom_maillot'].'</h3>';
            echo '<p class="prix-produit">29,99 &euro;</p>';
            
            echo '<a href="product.php?id='.$maillot['id_maillot'].'" class="bouton-voir">Voir les détails</a>';
            
            echo '</div>';
        } 
        echo '</div>';
        ?>

    </div> 

    <?php require_once("../includes/footer.php"); ?>

</body>
</html>