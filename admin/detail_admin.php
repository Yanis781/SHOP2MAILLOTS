<?php

    session_start();

    /* -----  VERIF ET REDIRECTION DU USER POUR VOIR SI C L'ADMIN OU PAS ----- */

    if ( !isset( $_SESSION['user'] ) ) {

        header('location: ../index.php');
        exit();

    } 

    if ( isset( $_SESSION['role'] ) && $_SESSION['role'] != 'admin' ) {

      header('location: ../shop/home.php');
        exit();

    }

    /* ------------------------------------------------------------------------ */

    require_once("../bdd/connect_db.php"); 
    
    /* -- INFO POUR AFFICHER LES DETAILLE DE LA COMMANDE (meme principe que panier) --*/

    if ( isset( $_GET['id_commande'] ) ) {

        $id_commande = $_GET['id_commande'];

        $req_commande = mysqli_query( $con, "SELECT U.nom_user, C.id_commande, C.nom_commande, C.statut, C.date_creation FROM commande C, user U WHERE C.id_user = U.id_user  AND id_commande = '$id_commande'" );
        $req_detaille_commande = mysqli_query( $con, "SELECT * FROM historique_commande WHERE id_commande = '$id_commande' " );
        $req_miniature = mysqli_query( $con, "SELECT M.nom_maillot, M.fichier_image FROM historique_commande H, maillot M WHERE H.id_commande = '$id_commande' AND H.id_maillot = M.id_maillot;");
      
        $commande = mysqli_fetch_array($req_commande);

        if ( !$commande ) {
            
            header("Location: dashboard.php");
            exit();
            
        }

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

        $date_formatee = date( 'd/m/Y à H:i', strtotime( $commande['date_creation'] ) );

    } else {

        header("location: home.php");
        exit();

    }

?>

<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title> SHOP2MAILLOTS { detail } </title>

        <link rel="stylesheet" href="../ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
        
    </head>

    <body>

        <?php require_once '../includes/header.php'; ?>

            <div class="conteneur-page">

                <h2 class="titre-page">Détails de la commande : <?php echo htmlspecialchars($commande['nom_commande']); ?></h2>

                <div style="margin-bottom: 25px;">

                    <a href="dashboard.php" class="lien-retour">⬅ Revenir au dashboard</a>
                
                </div>

                <?php 
                    
                    if ( isset( $_GET['edit-success'] ) ) {

                        echo "<div class='message-succes' style='margin-bottom: 20px; padding: 10px; border: 1px solid #28a745; background-color: #e9f7ef; border-radius: 4px;'>" . htmlspecialchars($_GET['edit-success']) . "</div>";
                    
                    }

                ?>

                <div class="carte-commande <?php echo $classe_carte; ?>" style="margin-bottom: 40px;">

                    <div class="entete-commande">

                        <div>

                            <h3 style="margin-bottom: 5px;">Résumé de la commande</h3>

                            <span style="font-size: 13px; color: #888;">Commande N° <?php echo $commande['id_commande']; ?> | Faite par : <strong><?php echo htmlspecialchars($commande['nom_user']); ?></strong></span>

                        </div>

                        <span class="statut-commande <?php echo $classe_couleur; ?>"><?php echo $texte_statut; ?></span>
                    
                    </div>

                    <p class="date-commande" style="margin: 0; margin-top: 15px;"><strong>Passée le :</strong> <?php echo $date_formatee; ?></p>
                
                </div>

                <div class="grille-panier" style="margin-bottom: 40px;">

                    <?php

                        while ( $detaille_commande = mysqli_fetch_array( $req_detaille_commande ) ) {

                            $miniature = mysqli_fetch_array( $req_miniature );

                            echo '<div class="carte-panier">';
                            echo '  <img src="../ressources/images/' . $miniature['fichier_image'] . '" alt="' . htmlspecialchars($miniature['nom_maillot']) . '" class="image-panier">';
                            
                            echo '  <div class="details-panier">';
                            echo '      <h3>' . htmlspecialchars($miniature['nom_maillot']) . '</h3>';
                            echo '      <p><strong>Taille :</strong> ' . htmlspecialchars( $detaille_commande['taille'] ) . '</p>';
                            echo '      <p><strong>Quantité :</strong> ' . htmlspecialchars( $detaille_commande['quantite'] ) . '</p>';
                            
                            /* ----- AFFICHAGE DU FLOCAGE ET NUMERO SI RENSEIGNÉS ----- */

                            if ( !empty( $detaille_commande['flocage'] ) && $detaille_commande['flocage'] != 'NULL' ) {

                                echo '      <p><strong>Flocage :</strong> ' . htmlspecialchars($detaille_commande['flocage']) . '</p>';
                            }
                                
                            if ( isset( $detaille_commande['numero'] ) && $detaille_commande['numero'] != '' && $detaille_commande['numero'] != 'NULL' ) {
                                echo '  <p><strong>Numéro :</strong> ' . htmlspecialchars($detaille_commande['numero']) . '</p>';
                            }

                            echo '  </div>';
                            
                            echo '  <div class="prix-panier">';
                            echo '      <p>29,99 &euro;</p>';
                            echo '  </div>';
                            
                            echo '</div>';

                        }

                    ?>

                </div>

                <div class="carte-parametre">

                    <h3 style="margin-top: 0; margin-bottom: 20px; text-transform: uppercase; border-bottom: 2px solid #f4f4f4; padding-bottom: 10px;">Actions Administrateur</h3>

                    <form method="post" action="gerer_commande.php" style="display: flex; gap: 15px; align-items: flex-end; margin-bottom: 25px;">
                        
                        <input type="hidden" name="id_commande" value="<?php echo $commande['id_commande']; ?>">
                        
                        <div class="groupe-input" style="flex: 1;">

                            <label for="statut">Modifier l'état de la commande :</label>
                            
                            <select name="status" id="statut" style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;" required>
                                <option value="en attente" >En attente</option>
                                <option value="pris en charge" >Prise en charge</option>
                                <option value="effectuer" >Effectuée</option>
                            </select>

                        </div>

                        <button type="submit" class="bouton-recherche" style="padding: 12px 25px;">Valider l'état</button>

                    </form>

                    <hr class="separateur">

                    <form method="post" action="gerer_commande.php" style="margin: 0;">

                        <input type="hidden" name="id_commande" value="<?php echo $commande['id_commande']; ?>">
                        <input type="hidden" name="supprimer" value="1">
                        
                        <button type="submit" class="bouton-danger" style="width: 100%;">Supprimer définitivement la commande</button>
                    
                    </form>

                </div>

            </div>
        
    </body>
</html>