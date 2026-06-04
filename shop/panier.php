<?php 
    session_start();

    /* -----  VERIF ET REDIRECTION DU USER POUR VOIR SI C L'ADMIN OU PAS ----- */

    if (!isset($_SESSION['user'])) {
        header('location: ../index.php');
        exit();
    }

    /* -----  SI user = admin, on le redirige vers le dashborad (La page d'administration du site) ----- */

    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        header('location: ../admin/dashboard.php');
        exit();
    }
    /* ------------------------------------------------------------------------ */
    require_once("../bdd/connect_db.php");
?>
<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SHOP2MAILLOTS { Panier }</title>
        
        <link rel="stylesheet" href="../ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">

    </head>

    <body>
        
        <?php require_once("../includes/header.php"); ?>

        <div class="conteneur-page">

            <!---- ENTETE HAUT DE PAGE ---->

            <h2 class="titre-page">VOTRE PANIER</h2>

            <!--- AFFICHAGE DES ARTICLES PRESENT DANS LE PANIER --->

            <div class="grille-panier">

                <?php 

                    $id_user = $_SESSION['id_user'];
                    
                    $result = mysqli_query( $con, "SELECT P.id_maillot, P.id_panier, M.nom_maillot, M.fichier_image, P.quantite, P.numero, P.flocage, P.taille FROM Panier P, User U, Maillot M WHERE P.id_maillot = M.id_maillot AND P.id_user = U.id_user AND U.id_user = '$id_user'" );
                    
                    /*---- AFFICHAGE DU PANIER UTILISATEUR ----*/

                    if ( mysqli_num_rows( $result ) > 0 ) {

                        while ( $panier = mysqli_fetch_array( $result )) {

                            echo '<div class="carte-panier">';
                            echo '  <img src="../ressources/images/' . $panier['fichier_image'] . '" alt="' . $panier['nom_maillot'] . '" class="image-panier">';
                            
                            echo '  <div class="details-panier">';
                            echo '      <h3>' . $panier['nom_maillot'] . '</h3>';
                            echo '      <p><strong>Taille :</strong> ' . $panier['taille'] . '</p>';
                            echo '      <p><strong>Quantité :</strong> ' . $panier['quantite'] . '</p>';
                            
                            

                            
                            /* ----- AFFICHAGE DU FLOCAGE ET NUMERO SI ILS ONT ETE RENSEIGNER PAR L'UTILISATEUR ----- */

                            if ( !empty( $panier['flocage'] ) && $panier['flocage'] != 'NULL' ) {

                                echo '      <p><strong>Flocage :</strong> '.$panier['flocage'].'</p>';

                            }
                            
                            /*
                            if (!empty($panier['numero']) && $panier['numero'] !== 'NULL') {
                                echo '      <p><strong>Numéro :</strong> '.$panier['numero'].'</p>';
                            } */
                        
                            if ( isset( $panier['numero'] ) && $panier['numero'] != '' && $panier['numero'] != 'NULL' ) {

                                echo '  <p><strong>Numéro :</strong> ' . $panier['numero'] . '</p>';

                            }
                            
                            echo '  <div class="supprimer-panier">';
                            echo   '<form method="POST" action="delete_panier.php">
                                        <input type="hidden" name="maillot_supp" value="'. $panier['id_panier'] .'">
                                        <button type="submit" name="boutton-supprimer">Supprimer ce maillot</button>
                                    </form>';
                            echo '  </div>';       
                                
                            echo '  </div>';
                            
                            echo '  <div class="prix-panier">';

                            $prix_total_ligne = 29.99 * intval( $panier['quantite'] );

                            echo '      <p>' . number_format($prix_total_ligne, 2, ',', ' ') . ' &euro;</p>';
                            echo '  </div>';
                            
                            echo '</div>';
                            
                        }
                            echo' <form method="post" action="valid_commande.php" class="form-validation">

                                <input type="text" name="nom_commande" placeholder="Nom de la commande *" required>

                                <button type="submit" class="bouton-valider">Valider le panier</button>

                                </form>';
                    } else {

                        /* ----- AFFICHAGE D'UN MESSAGE SI LE PANIER EST VIDE ----- */

                        echo '<p class="message-vide">Votre panier est actuellement vide.</p>';

                    }

                ?>
                
            </div> 

            <!--- AFFICHAGE FORMULAIRE DE VALIDATION DE COMMANDE SI LE PANIER EST PAS VIDE --->

            

            <hr class="separateur">

            <!--- AFFICHAGE DES COMMANDES DE L'UTILISATEUR --->

            <h2 class="titre-page">VOS COMMANDES</h2>
            
            <div class="grille-commandes">

                <?php 

                    $req_commandes = mysqli_query( $con, "SELECT * FROM commande WHERE id_user = '$id_user' ORDER BY date_creation DESC " );

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

                            echo "<div class='carte-commande " . $classe_carte . "'>";

                            echo "  <div class='entete-commande'>";
                            echo "      <div>";
                            echo "          <h3 style='margin-bottom: 5px;'>" . htmlspecialchars( $commande['nom_commande'] ) . "</h3>";
                            echo "          <span style='font-size: 13px; color: #888;'>Commande N° " . $id_commande_actuelle . "</span>";
                            echo "      </div>";
                            echo "      <span class='statut-commande ".$classe_couleur."'>" . $texte_statut . "</span>";
                            echo "  </div>";
                            
                            echo "  <hr class='separateur'>";
                            
                            echo "  <div class='miniatures-commande'>";

                            for( $i = 0; $i < 4; $i++ ) {

                                if ( $miniature = mysqli_fetch_array( $req_miniature ) ) {
                                    
                                    echo '  <img src="../ressources/images/' . $miniature['fichier_image'] . '" class="miniature-img" alt="' . htmlspecialchars($miniature['nom_maillot']) . '" title="' . htmlspecialchars($miniature['nom_maillot']) . '">';
                                }

                            }

                            echo "  </div>";
                            
                            $date_formatee = date('d/m/Y à H:i', strtotime($commande['date_creation']));
                            
                            echo "  <div class='bas-commande'>";
                            echo "      <p class='date-commande' style='margin: 0;'><strong>Passée le :</strong> " . $date_formatee . "</p>";
                            echo "      <a href='detail_commande.php?id_commande=" . $id_commande_actuelle . "' class='bouton-detail'>Voir les détails</a>";
                            echo "  </div>";

                            echo "</div>";

                        }

                    } else {

                        echo "<h2 style='text-align: center;'>Pas de commande pour l'instant...</h2>";
                        echo "<p style='text-align: center; color: #666;'>Ne perds pas de temps ! Rajoute des maillots dans ton panier et passe ta prochaine commande !</p>";
                    
                        }

                ?>

            </div>

        </div> 
        
        <?php require_once("../includes/footer.php"); ?> 

    </body>

</html>