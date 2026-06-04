<?php
    session_start();

    if (!isset($_SESSION['user']) || $_SESSION['user'] != 'Admin') {
        header('location: ../index.php');
        exit();
    }
    
    require_once("../bdd/connect_db.php");

    $req_nbr = mysqli_query( $con,"SELECT COUNT(*) FROM commande" );
    $row = mysqli_fetch_row( $req_nbr );
    $nbr = $row[0];

    $message_de_base = "";

    if ($nbr > 1) {

        $message_de_base = "Il y a actuellement : ".$nbr." commandes.";

    } elseif ($nbr == 1) {

        $message_de_base = "Il y a actuellement 1 seule commande.";

    } else {

        $message_de_base = "Il n'y a actuellement aucune commande...";

    }

?>

<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title> SHOP2MAILLOTS { Dashboard } </title>

        <link rel="stylesheet" href="../ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
        
    </head>

    <body>

        <?php require_once("../includes/header.php"); ?>

        <div class="conteneur-page">
            
            <h2 class="titre-page">Gérer les commandes clients</h2>
            
            <p class="sous-titre-bienvenue"><?php echo $message_de_base; ?></p>

            <hr class="separateur">

            <div class="grille-commandes">

                <?php

                    $req_commandes = mysqli_query( $con, "SELECT U.nom_user, C.id_commande, C.nom_commande, C.statut, C.date_creation FROM commande C, user U WHERE C.id_user = U.id_user ORDER BY date_creation DESC " );

                        if ( mysqli_num_rows( $req_commandes ) > 0 ) {

                            while ( $commande = mysqli_fetch_array( $req_commandes ) ) {

                                $id_commande_actuelle = $commande['id_commande'];
                                $req_miniature = mysqli_query( $con, "SELECT M.nom_maillot, M.fichier_image FROM historique_commande H, maillot M WHERE H.id_commande = '$id_commande_actuelle' AND H.id_maillot = M.id_maillot;");
                                
                                echo "<div class='carte-commande'>";

                                echo "  <h2>" . $commande['nom_commande'] . "</h2>";
                                echo "  <p>id de la commande : <strong>" . $commande['id_commande'] . ".</strong></p>";
                                echo "  <p>statut : <strong>" . $commande['statut'] . "</strong></p>";
                                echo "  <p>Commande réaliser par : <strong>" . $commande['nom_user'] . "</strong></p>";
                                echo "  <hr>";
                                
                                for($i = 0; $i < 4; $i++) {
                                
                                    if ($miniature = mysqli_fetch_array( $req_miniature )){
                                
                                        echo '  <img src="../ressources/images/' . $miniature['fichier_image'] . '" class="image-produit" alt="' . $miniature['nom_maillot'] . '">';
                                
                                    }

                                }
                                
                                echo "  <p><strong>". $commande['date_creation'] . "</strong></p>";
                                echo "  <a href='detail_admin.php?id_commande=" . $id_commande_actuelle . "'>Voir le détaille de la commande</a>";

                                echo "</div>";

                            }

                        } else {

                            echo "<h2>Pas de commande pour l'instant...</h2>";
                            echo "<p>Ne perd pas de temps ! Rajoute des maillots dans ton panier et passe t'as prochaine commande ! ";
                            
                        }

                ?>

            </div>
        </div>

    </body>

</html>