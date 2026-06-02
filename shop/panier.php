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

    <div class="conteneur-page">

        <h2 class="titre-page">VOTRE PANIER</h2>

        <div class="grille-panier">
            <?php 
                $id_user = $_SESSION['id_user'];
                
                $result = mysqli_query($con, "SELECT P.id_maillot, M.nom_maillot, M.fichier_image, P.quantite, P.numero, P.flocage, P.taille FROM Panier P, User U, Maillot M WHERE P.id_maillot = M.id_maillot AND P.id_user = U.id_user AND U.id_user = '$id_user'");
                
                if (mysqli_num_rows($result) > 0) {
                    while ($panier = mysqli_fetch_array($result)) {
                        echo '<div class="carte-panier">';
                        echo '  <img src="../ressources/images/'.$panier['fichier_image'].'" alt="'.$panier['nom_maillot'].'" class="image-panier">';
                        
                        echo '  <div class="details-panier">';
                        echo '      <h3>'.$panier['nom_maillot'].'</h3>';
                        echo '      <p><strong>Taille :</strong> '.$panier['taille'].'</p>';
                        echo '      <p><strong>Quantité :</strong> '.$panier['quantite'].'</p>';
                        
                        if (!empty($panier['flocage']) && $panier['flocage'] !== 'NULL') {
                            echo '      <p><strong>Flocage :</strong> '.$panier['flocage'].'</p>';
                        }
                        
                        /*
                        if (!empty($panier['numero']) && $panier['numero'] !== 'NULL') {
                            echo '      <p><strong>Numéro :</strong> '.$panier['numero'].'</p>';
                        } */
                       
                        if (isset($panier['numero']) && $panier['numero'] !== '' && $panier['numero'] !== 'NULL') {
                            echo '  <p><strong>Numéro :</strong> ' . $panier['numero'] . '</p>';
                        }

                        echo '  </div>';
                        
                        echo '  <div class="prix-panier">';
                        echo '      <p>29,99 &euro;</p>';
                        echo '  </div>';
                        
                        echo '</div>';
                    }
                } else {
                    echo '<p class="message-vide">Votre panier est actuellement vide.</p>';
                }
            ?>
        </div> 

        <?php if (mysqli_num_rows($result) > 0) { // On n'affiche le formulaire que si le panier n'est pas vide ?>
        <form method="post" action="Valid_commande.php" class="form-validation">
            <input type="text" name="nom_commande" placeholder="Nom de la commande *" required>
            <button type="submit" class="bouton-valider">Valider le panier</button>
        </form>
        <?php } ?>

        <hr class="separateur">

        <h2 class="titre-page">VOS COMMANDES</h2>
        
        <div class="grille-commandes">
            <?php 
                $result_cmd = mysqli_query($con, "SELECT C.id_commande, C.nom_commande, C.date_creation, C.statut, H.id_maillot, M.nom_maillot FROM Commande C, historique_commande H, Maillot M WHERE C.id_commande = H.id_commande AND H.id_maillot = M.id_maillot AND C.id_user = '$id_user' ORDER BY C.date_creation DESC, C.id_commande DESC");
                
                $id_commande_en_cours = null;

                if (mysqli_num_rows($result_cmd) > 0) {
                    while ($ligne = mysqli_fetch_array($result_cmd)) {
                        
                        if ($ligne['id_commande'] !== $id_commande_en_cours) {
                            
                            if ($id_commande_en_cours !== null) {
                                echo '  </div>'; 
                                echo '</div>';   
                            }
                            
                            echo '<div class="carte-commande">';
                            echo '  <div class="entete-commande">';
                            echo '      <h3>'.$ligne['nom_commande'].'</h3>';
                            echo '      <span class="statut-commande">'.$ligne['statut'].'</span>';
                            echo '  </div>';
                            echo '  <p class="date-commande"><strong>Date :</strong> '.$ligne['date_creation'].'</p>';
                            echo '  <div class="maillots-commande">';

                            $id_commande_en_cours = $ligne['id_commande'];
                        }

                        echo '      <p class="maillot-item">• '.$ligne['nom_maillot'].'</p>';
                    }

                    if ($id_commande_en_cours !== null) {
                        echo '  </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="message-vide">Vous n\'avez passé aucune commande pour le moment.</p>';
                }
            ?>
        </div>

    </div> <?php require_once("../includes/footer.php"); ?> 

</body>
</html>