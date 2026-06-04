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

        <div class="conteneur-dashboard">
            
            <h2 class="titre-page">Gérer les commandes clients</h2>
            
            <p class="sous-titre-bienvenue"><?php echo $message_de_base; ?></p>

            <hr class="separateur">

            <div class="grille-commandes-admin">

                <?php
                    $req_commandes = mysqli_query( $con, "SELECT U.nom_user, C.id_commande, C.nom_commande, C.statut, C.date_creation FROM commande C, user U WHERE C.id_user = U.id_user ORDER BY date_creation DESC " );

                    if ( mysqli_num_rows( $req_commandes ) > 0 ) {

                        while ( $commande = mysqli_fetch_array( $req_commandes ) ) {

                            $id_commande_actuelle = $commande['id_commande'];
                            $req_miniature = mysqli_query( $con, "SELECT M.nom_maillot, M.fichier_image FROM historique_commande H, maillot M WHERE H.id_commande = '$id_commande_actuelle' AND H.id_maillot = M.id_maillot;");
                            

                            if ( $commande['statut'] == 'effectuer' ) {

                                $texte_statut = "Effectuée";
                                $classe_couleur = "statut-vert";
                                $classe_carte = "carte-verte";

                            } elseif ( $commande['statut'] == 'pris en charge' ) {

                                $texte_statut = "Prise en charge";
                                $classe_couleur = "statut-orange";
                                $classe_carte = "carte-orange";

                            } else {

                                $texte_statut = "En attente";
                                $classe_couleur = "statut-noir";
                                $classe_carte = ""; 

                            }

                            $date_formatee = date('d/m/Y à H:i', strtotime($commande['date_creation']));

                            echo "<div class='carte-commande " . $classe_carte . "'>";

                            echo "  <div class='entete-commande'>";
                            echo "      <div>";
                            echo "          <h3 style='margin-bottom: 5px; font-size: 16px;'>" . htmlspecialchars($commande['nom_commande']) . "</h3>";
                            echo "          <span style='font-size: 12px; color: #888;'>N° " . $id_commande_actuelle . " | Par " . htmlspecialchars($commande['nom_user']) . "</span>";
                            echo "      </div>";
                            echo "      <span class='statut-commande ".$classe_couleur."'>" . $texte_statut . "</span>";
                            echo "  </div>";
                            
                            echo "  <hr class='separateur'>";
                            
                            echo "  <div class='miniatures-commande'>";

                            for( $i = 0; $i < 4; $i++ ) {

                                if ( $miniature = mysqli_fetch_array( $req_miniature ) ) {

                                    echo '  <img src="../ressources/images/' . $miniature['fichier_image'] . '" class="miniature-img" alt="' . htmlspecialchars($miniature['nom_maillot']) . '">';
                                
                                    }

                            }

                            echo "  </div>";
                            
                            echo "  <div class='bas-commande' style='margin-bottom: 15px;'>";
                            echo "      <p class='date-commande' style='margin: 0; font-size:12px;'><strong>" . $date_formatee . "</strong></p>";
                            echo "      <a href='detail_admin.php?id_commande=" . $id_commande_actuelle . "' class='bouton-detail'>Détails</a>";
                            echo "  </div>";

                            echo "  <div class='actions-admin' style='background-color: #f8f9fa; padding: 15px; border-radius: 4px; border: 1px solid #eee; margin-top: auto;'>";
                            
                            echo "      <form method='post' action='gerer_commande.php' style='display:flex; gap:10px; align-items:center; margin-bottom: 10px;'>";
                            echo "          <input type='hidden' name='id_commande' value='" . $id_commande_actuelle . "'>";
                            echo "          <select name='status' style='padding: 8px; width: 100%; border: 1px solid #ccc; border-radius: 4px; font-size: 13px;' required>";                            
                            echo "              <option value='en attente'>En attente</option>";
                            echo "              <option value='pris en charge'>Prise en charge</option>";
                            echo "              <option value='effectuer'>Effectuée</option>";
                            echo "          </select>";
                            echo "          <button type='submit' class='bouton-recherche' style='padding: 8px 12px; font-size: 12px;'>OK</button>";
                            echo "      </form>";

                            echo "      <form method='post' action='gerer_commande.php' style='margin: 0;'>";
                            echo "          <input type='hidden' name='id_commande' value='" . $id_commande_actuelle . "'>";
                            echo "          <input type='hidden' name='supprimer' value='1'>";
                            echo "          <button type='submit' class='bouton-danger' style='width: 100%; padding: 8px; font-size: 12px;'>Supprimer la commande</button>";
                            echo "      </form>";
                            
                            echo "  </div>";

                            echo "</div>"; 

                        }

                    } else {

                        echo "<h2 style='text-align: center;'>Pas de commande pour l'instant...</h2>";
                        
                    }
                ?>

            </div>

        </div>

    </body>

</html>