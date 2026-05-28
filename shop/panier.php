<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: ../index.php');
        exit();
    }

    require_once("../bdd/connect_db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../ressources/css/styles.css">
    <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
    <title>DSHOP2MAILLOTS { Panier }</title>
</head>
<body>
    
    <?php require_once("../includes/header.php"); ?>

    <h2 class="titre-page">VOTRE PANIER</h2>

    <div>
        <?php 

            $id_user = $_SESSION['id_user'];
            $result = mysqli_query($con, "SELECT P.id_maillot, M.nom_maillot, M.fichier_image, P.quantite, P.numero, P.flocage, P.taille FROM panier P, user U, Maillot M WHERE P.id_maillot = M.id_maillot AND P.id_user = U.id_user AND U.id_user = '$id_user'");

            while ($pannier = mysqli_fetch_array($result)) {
                echo '<p class="nom-produit">'.$pannier['nom_maillot'].'</p>';
                echo '<img src="../ressources/images/'.$pannier['fichier_image'].'" alt="'.$pannier['nom_maillot'].'" width="400" height="400" class="image-produit">';
                echo '<p class="prix-produit"> Quantité : '.$pannier['quantite'].'</p><br>';

                if (!empty($pannier['flocage'])) {
                    echo '<p> Flocage : '.$pannier['flocage'].'</p><br>';
                }

                if (!empty($pannier['nuemro'])) {
                    echo '<p> Flocage : '.$pannier['numero'].'</p><br>';
                }

                echo '<p class="prix-produit">29,99 &euro;</p>';
                echo "<br>";
            }
        ?>
    </div>



    <form method="post" action="Valid_commande.php">
        <input type="text" name="nom_commande" placeholder="Nom de la commande *" required>

        <button type="submit">Valider le panier</button>
    </form>

    <hr>

    <h2 class="titre-page">VOS COMMANDE</h2>

    <?php require_once("../includes/footer.php"); ?>

</body>
</html>