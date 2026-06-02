<?php
    session_start();

    if (!isset($_SESSION['user']) || $_SESSION['user'] != 'Admin') {
        header('location: ../index.php');
        exit();
    }
    
    require_once("../bdd/connect_db.php");

    $req_nbr = mysqli_query($con,"SELECT COUNT(*) FROM commande");
    $row = mysqli_fetch_row($req_nbr);
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
<html lang="fr">
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
                $result_cmd = mysqli_query($con, "SELECT C.id_commande, C.nom_commande, C.date_creation, C.statut, H.id_maillot, M.nom_maillot FROM Commande C, historique_commande H, Maillot M WHERE C.id_commande = H.id_commande AND H.id_maillot = M.id_maillot ORDER BY C.date_creation DESC, C.id_commande DESC");
                
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
                    echo '<p class="message-vide">Vous n\'avez reçu aucune commande pour le moment.</p>';
                }
            ?>
        </div>
    </div>

    <?php require_once("../includes/footer.php"); ?>
</body>
</html>