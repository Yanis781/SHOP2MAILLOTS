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
    
    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title> SHOP2MAILLOTS { Page d'accueil }  </title>
        <link rel="stylesheet" href="../ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
    </head>
    <body>
        <?php require_once '../includes/header.php'; ?>
        
        <?php 
            if (isset($_GET['edit-success'])) {
                echo "<p class='message-succes'>".$_GET['edit-success']."</p>";
            }
        ?>

        <div class="conteneur-catalogue">
            
            <div class="bienvenue-hero">
                <h1 class="titre-bienvenue">Welcome back, <?php echo $user; ?> !</h1>
                <p class="sous-titre-bienvenue">Prêt à trouver ton prochain maillot ?</p>
            </div>

            <div class="zone-recherche-accueil">
                <form method="get" action="catalogue.php" class="barre-recherche">
                    <input type="text" class="input-recherche" placeholder="Rechercher un maillot..." name="recherche">
                    <button class="bouton-recherche" type="submit">Rechercher</button>
                </form>
            </div>

            <div class="banniere-image-container">
                <a href="catalogue.php">
                    <img src="../ressources/images/banierre.png" alt="Tous les maillots au meilleur prix" class="image-banniere-promo">
                </a>
            </div>

            <div class="barre-reassurance">
                <div class="reassurance-item">
                    <div class="icone-ronde">👕</div> 
                    <h4>Qualité Premium</h4>
                    <p>Finitions parfaites garanties</p>
                </div>
                <div class="reassurance-item">
                    <div class="icone-ronde">🌍</div>
                    <h4>Clubs Européens</h4>
                    <p>Les plus grandes équipes</p>
                </div>
                <div class="reassurance-item">
                    <div class="icone-ronde">📞</div>
                    <h4>Support Réactif</h4>
                    <p>Une équipe à votre écoute</p>
                </div>
                <div class="reassurance-item">
                    <div class="icone-ronde">🔄</div>
                    <h4>Retours Simplifiés</h4>
                    <p>Échange possible sous 14 jours</p>
                </div>
            </div>

            <hr class="separateur-section">

            <h2 class="titre-section">🔥 LES NOUVEAUTÉS</h2>
            
            <div class="grille-produits">
                <?php 
                $req_nouveautes = "SELECT id_maillot, nom_maillot, fichier_image FROM Maillot ORDER BY id_maillot DESC LIMIT 10";
                $result_nouveautes = mysqli_query($con, $req_nouveautes);

                if (mysqli_num_rows($result_nouveautes) > 0) {

                    while ($maillot = mysqli_fetch_array($result_nouveautes)) {
                            echo '<div class="carte-produit">';
                            echo '  <img src="../ressources/images/'.$maillot['fichier_image'].'" class="image-produit" alt="'.$maillot['nom_maillot'].'">';
                            echo '  <h3 class="nom-produit">'.$maillot['nom_maillot'].'</h3>';

                            echo '  <p class="prix">29,99 &euro;</p>';
                            echo '  <a href="product.php?id-maillot='.$maillot['id_maillot'].'" class="bouton-voir">Voir le maillot</a>';
                            echo '</div>';
                    }
                } else {
                    echo "<p class='message-vide'>Aucune nouveauté pour le moment.</p>";
                }
                ?>
            </div>

        </div>

        <?php require_once '../includes/footer.php'; ?>
    </body>
</html>