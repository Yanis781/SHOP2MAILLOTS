<?php
    session_start();

    /* -----  VERIF ET REDIRECTION DU USER POUR VOIR SI C L'ADMIN OU PAS ----- */

    if ( !isset( $_SESSION['user'] ) ) {

        header('location: ../index.php');
        exit();

    } 

    if ( isset( $_SESSION['role'] ) && $_SESSION['role'] == 'admin' ) {

        header('location: ../admin/dashboard.php');
        exit();

    }

    /* ------------------------------------------------------------------------ */

    require_once("../bdd/connect_db.php"); 
    
    /* -- INFO POUR AFFICHER LES DETAILLE DE LA COMMANDE (meme principe que panier) --*/

    if ( isset( $_GET['id_commande'] ) ) {

        $id_commande = $_GET['id_commande'];
        $id_user = $_SESSION['id_user'];

        $req_commande = mysqli_query( $con, "SELECT * FROM commande WHERE id_commande = '$id_commande' AND id_user = '$id_user' " );
        $req_detaille_commande = mysqli_query( $con, "SELECT * FROM historique_commande WHERE id_commande = '$id_commande' " );
        $req_miniature = mysqli_query( $con, "SELECT M.nom_maillot, M.fichier_image FROM historique_commande H, maillot M WHERE H.id_commande = '$id_commande' AND H.id_maillot = M.id_maillot;");
      
        $commande = mysqli_fetch_array( $req_commande );



    } else {

        header("location : home.php");
        exit();

    }

?>

<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SHOP2MAILLOTS { detaille panier } </title>
        
        <link rel="stylesheet" href="../ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">

    </head>

    <body>
    
        <?php require_once '../includes/header.php'; ?>

        <div class="conteneur-page">

            <h2 class="titre-page">detaille de la commande : <?php echo $commande['nom_commande']; ?></h2>

            <p><?php echo "id de la commande : <strong>" . $commande['id_commande'] . " </strong>";?></p>
            <p><?php echo "Etat : <strong>" . $commande['statut'] . " </strong>"; ?></p>
            <p><?php echo "Commander le <strong>" . $commande['date_creation'] . " </strong>"; ?></p>

            <a href="panier.php" class="navigation-principale"> ⬅ Revenir aux panier</a>
            
            <?php 
            
                while ( $detaille_commande = mysqli_fetch_array( $req_detaille_commande ) ) {

                    $miniature = mysqli_fetch_array( $req_miniature );

                    echo '<div class="carte-panier">';
                    echo '  <img src="../ressources/images/' . $miniature['fichier_image'] . '" alt="' . $miniature['nom_maillot'] . '" class="image-panier">';
                    
                    echo '  <div class="details-panier">';
                    echo '      <h3>' . $miniature['nom_maillot'] . '</h3>';
                    echo '      <p><strong>Taille :</strong> ' . $detaille_commande['Taille'] . '</p>';
                    echo '      <p><strong>Quantité :</strong> ' . $detaille_commande['quantite'] . '</p>';
                    
                    /* ----- AFFICHAGE DU FLOCAGE ET NUMERO SI ILS ONT ETE RENSEIGNER PAR L'UTILISATEUR ----- */

                    if ( !empty( $detaille_commande['flocage'] ) && $detaille_commande['flocage'] != 'NULL' ) {

                        echo '      <p><strong>Flocage :</strong> ' . $detaille_commande['flocage'] . '</p>';

                    }
                        
                    if ( isset( $detaille_commande['numero'] ) && $detaille_commande['numero'] != '' && $detaille_commande['numero'] != 'NULL' ) {

                        echo '  <p><strong>Numéro :</strong> ' . $detaille_commande['numero'] . '</p>';

                    }

                    echo '  </div>';
                    
                    echo '  <div class="prix-panier">';
                    echo '      <p>29,99 &euro;</p>';
                    echo '  </div>';
                    
                    echo '</div>';

                }

            ?>

        </div>



        <?php require_once '../includes/footer.php'; ?>

    </body>

</html>