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
      
        $commande = mysqli_fetch_array($req_commande);

        if ( !$commande ) {
            
            header("Location: home.php");
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

        $date_formatee = date('d/m/Y à H:i', strtotime($commande['date_creation']));


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

        <title>SHOP2MAILLOTS { detaille panier } </title>
        
        <link rel="stylesheet" href="../ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">

    </head>

    <body>
    
        <?php require_once '../includes/header.php'; ?>

        <div class="conteneur-page">

            <h2 class="titre-page">Détails de la commande : <?php echo htmlspecialchars($commande['nom_commande']); ?></h2>

            <div style="margin-bottom: 25px;">
                <a href="panier.php" class="lien-retour">⬅ Revenir aux commandes</a>
            </div>

            <div class="carte-commande <?php echo $classe_carte; ?>" style="margin-bottom: 40px;">
                <div class="entete-commande">
                    <div>
                        <h3 style="margin-bottom: 5px;">Résumé de la commande</h3>
                        <span style="font-size: 13px; color: #888;">Commande N° <?php echo $commande['id_commande']; ?></span>
                    </div>
                    <span class="statut-commande <?php echo $classe_couleur; ?>"><?php echo $texte_statut; ?></span>
                </div>
                <p class="date-commande" style="margin: 0; margin-top: 15px;"><strong>Passée le :</strong> <?php echo $date_formatee; ?></p>
            </div>
            
            <div class="grille-panier">

            <?php

                while ( $detaille_commande = mysqli_fetch_array( $req_detaille_commande ) ) {

                    $miniature = mysqli_fetch_array( $req_miniature );

                    echo '<div class="carte-panier">';
                    echo '  <img src="../ressources/images/' . $miniature['fichier_image'] . '" alt="' . htmlspecialchars( $miniature['nom_maillot'] ) . '" class="image-panier">';
                    
                    echo '  <div class="details-panier">';
                    echo '      <h3>' . htmlspecialchars($miniature['nom_maillot']) . '</h3>';
                    echo '      <p><strong>Taille :</strong> ' . htmlspecialchars($detaille_commande['taille']) . '</p>';
                    echo '      <p><strong>Quantité :</strong> ' . htmlspecialchars($detaille_commande['quantite']) . '</p>';
                    
                    if ( !empty( $detaille_commande['flocage'] ) && $detaille_commande['flocage'] != 'NULL' ) {

                        echo '      <p><strong>Flocage :</strong> ' . htmlspecialchars($detaille_commande['flocage']) . '</p>';
                    
                        }
                        
                    if ( isset( $detaille_commande['numero'] ) && $detaille_commande['numero'] != '' && $detaille_commande['numero'] != 'NULL' ) {
                        
                        echo '  <p><strong>Numéro :</strong> ' . htmlspecialchars( $detaille_commande['numero'] ) . '</p>';
                    
                    }

                    echo '  </div>';
                    
                    echo '  <div class="prix-panier">';
                    
                    $prix_total_ligne = 29.99 * intval( $detaille_commande['quantite'] );

                    echo '      <p>' . number_format($prix_total_ligne, 2, ',', ' ') . ' &euro;</p>';
                    echo '  </div>';
                    
                    echo '</div>';
                }
            ?>

            </div>

        </div>

        <?php require_once '../includes/footer.php'; ?>

    </body>

</html>