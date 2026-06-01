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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../ressources/css/styles.css">
    <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
    <title>SHOP2MAILLOTS { Panier }</title>
</head>
<body>
    
    <?php require_once("../includes/header.php"); ?>

    <h2 class="titre-page">VOTRE PANIER</h2>

    <div>
        <?php 
            $id_user = $_SESSION['id_user'];
            
            // Requête du panier
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
    </div> 

    <form method="post" action="Valid_commande.php" class="form-validation">
        <input type="text" name="nom_commande" placeholder="Nom de la commande *" required>
        <button type="submit" class="bouton-valider">Valider le panier</button>
    </form>

    <hr>

    <h2 class="titre-page">VOS COMMANDES</h2>
    
    <div>
        <?php 
            // Requête de l'historique avec tri par ID de commande pour regrouper les lignes
            $result_cmd = mysqli_query($con, "SELECT C.id_commande, C.nom_commande, C.date_creation, C.statut, H.id_maillot, M.nom_maillot FROM Commande C, historique_commande H, Maillot M WHERE C.id_commande = H.id_commande AND H.id_maillot = M.id_maillot AND C.id_user = '$id_user' ORDER BY C.date_creation DESC, C.id_commande DESC");
            
            // Logique procédurale (Rupture de contrôle)
            $id_commande_en_cours = null;

            if (mysqli_num_rows($result_cmd) > 0) {
                while ($ligne = mysqli_fetch_array($result_cmd)) {
                    
                    // Si on détecte un nouvel ID de commande
                    if ($ligne['id_commande'] !== $id_commande_en_cours) {
                        
                        // On ouvre la nouvelle boîte de commande
                        echo '<div class="carte-commande">';
                        echo '  <h3>'.$ligne['nom_commande'].'</h3>';
                        echo '  <p><strong>Date :</strong> '.$ligne['date_creation'].'</p>';
                        echo '  <p><strong>Statut :</strong> '.$ligne['statut'].'</p>';
                        echo '  <div class="maillots-commande">';

                        // On met à jour notre variable de vérification
                        $id_commande_en_cours = $ligne['id_commande'];
                    }

                    // On affiche le maillot pour cette commande
                    echo '    <p class="maillot-item">• '.$ligne['nom_maillot'].'</p>';
                }

                // Fin de la boucle : on ferme la toute dernière commande
                if ($id_commande_en_cours !== null) {
                    echo '  </div>';
                    echo '</div>';
                }
            } else {
                echo '<p style="text-align: center;">Vous n\'avez passé aucune commande pour le moment.</p>';
            }
        ?>
    </div>

    <?php require_once("../includes/footer.php"); ?> 

</body>
</html>