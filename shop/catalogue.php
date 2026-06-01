<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: ../index.php');
        exit();
    }

    require_once("../bdd/connect_db.php");

    $req = "";
    $titre_page = "CATALOGUE";

    // Tout est en GET !
    if (isset($_GET['recherche']) && !empty(trim($_GET['recherche']))) { 
        
        $mot_cle = mysqli_real_escape_string($con, trim($_GET['recherche']));
        
        $req = "SELECT id_maillot, nom_maillot, fichier_image FROM Maillot WHERE nom_maillot LIKE '%$mot_cle%'";
        
        // htmlspecialchars évite les failles si l'utilisateur tape du code HTML
        $titre_page = "RÉSULTATS POUR : " . htmlspecialchars($mot_cle);

    } else {
        $req = "SELECT id_maillot, nom_maillot, fichier_image FROM Maillot";
    }
    $result = mysqli_query($con, $req);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title> SHOP2MAILLOTS { catalogue } </title>
    <link rel="stylesheet" href="../ressources/css/styles.css">
    <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
</head>
<body>

    <?php require_once("../includes/header.php"); ?>

    <div class="conteneur-catalogue">
            <h1 class="titre-page"><?php echo $titre_page; ?></h1>

           <div class="zone-recherche-catalogue">
                <form method="GET" action="catalogue.php" class="barre-recherche">
                    <input type="text" name="recherche" class="input-recherche" placeholder="Rechercher un autre maillot..." value="<?php echo isset($_GET['recherche']) ? htmlspecialchars(trim($_GET['recherche'])) : ''; ?>" required>
                    <button type="submit" class="bouton-recherche">Chercher</button>
                </form>
            </div>

            <div class="grille-produits">
                <?php 
                    if (mysqli_num_rows($result) > 0) {
                        
                        while ($maillot = mysqli_fetch_array($result)) {
                            echo '<div class="carte-produit">';
                            echo '  <img src="../ressources/images/'.$maillot['fichier_image'].'" class="image-produit" alt="'.$maillot['nom_maillot'].'">';
                            echo '  <h3 class="nom-produit">'.$maillot['nom_maillot'].'</h3>';

                            echo '  <p class="prix">29,99 &euro;</p>';
                            echo '  <a href="product.php?id-maillot='.$maillot['id_maillot'].'" class="bouton-voir">Voir le maillot</a>';
                            echo '</div>';
                        }

                    } else {
                        echo '<p style="text-align:center; width:100%;">Désolé, nous n\'avons pas trouvé de maillot correspondant.</p>';
                        echo "<a class='bouton-recherche' href='catalogue.php'>Voir les maillot disponible</a>";
                    }
                    ?>
            </div>
        </div>

    <?php require_once("../includes/footer.php"); ?>

</body>
</html>