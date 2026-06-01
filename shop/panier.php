<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: ../index.php');
        exit();
    }

    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        header('location: ../admin/dashboard.php');
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
            $result = mysqli_query($con, "SELECT P.id_maillot, M.nom_maillot, M.fichier_image, P.quantite, P.numero, P.flocage, P.taille FROM Panier P, User U, Maillot M WHERE P.id_maillot = M.id_maillot AND P.id_user = U.id_user AND U.id_user = '$id_user'");

            while ($pannier = mysqli_fetch_array($result)) {
                echo '<div class="carte-panier">';
                
                echo '<img src="../ressources/images/'.$pannier['fichier_image'].'" alt="'.$pannier['nom_maillot'].'" class="image-panier">';
                
                
                echo '<div class="details-panier">';
                echo '  <h3>'.$pannier['nom_maillot'].'</h3>';
                echo '  <p><strong>Taille :</strong> '.$pannier['taille'].'</p>';
                echo '  <p><strong>Quantité :</strong> '.$pannier['quantite'].'</p>';
                
                if (!empty($pannier['flocage']) && $pannier['flocage'] !== 'NULL') {
                    echo '  <p><strong>Flocage :</strong> '.$pannier['flocage'].'</p>';
                }
                
                if (!empty($pannier['numero']) && $pannier['numero'] !== 'NULL') {
                    echo '  <p><strong>Numéro :</strong> '.$pannier['numero'].'</p>';
                }
                echo '</div>';

                
                echo '<div class="prix-panier">';
                echo '  <p>29,99 &euro;</p>';
                echo '</div>';
                
                echo '</div>';
            }
        ?>

    </div> <form method="post" action="Valid_commande.php" class="form-validation">
        <input type="text" name="nom_commande" placeholder="Nom de la commande *" required>
        <button type="submit" class="bouton-valider">Valider le panier</button>
    </form>

    <hr>

    <h2 class="titre-page">VOS COMMANDES</h2>

    <?php require_once("../includes/footer.php"); ?>

</body>
</html>