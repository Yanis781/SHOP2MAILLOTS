<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: ../index.php');
        exit();
    }

    require_once("../bdd/connect_db.php");

    if (!isset($_GET['id-maillot'])) {
        header('location: catalogue.php');
        exit();
    } else {
        
        $id_choix = intval($_GET['id-maillot']); 
        $result = mysqli_query($con, "SELECT id_maillot, nom_maillot, fichier_image FROM Maillot WHERE id_maillot = $id_choix");
        $maillot = mysqli_fetch_array($result);
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOP2MAILLOTS { Choix Maillot }</title>
    <link rel="stylesheet" href="../ressources/css/styles.css">
    <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
</head>
<body>

    <?php require_once("../includes/header.php"); ?>

    <div class="conteneur-page">
        <h1 class="titre-page">PERSONNALISER LE MAILLOT</h1>

        <div class="conteneur-produit">
            
            <div class="colonne-image">
                <?php echo '<img src="../ressources/images/'.$maillot['fichier_image'].'" alt="'.$maillot['nom_maillot'].'" class="image-detail">'; ?>
            </div>

            <div class="colonne-formulaire">

                <div class="entete-formulaire">
                    <h2><?php echo $maillot['nom_maillot']; ?></h2>
                    <span class="prix-detail">29,99 &euro;</span>
                </div>

                <form method="post" action="ajout_panier.php" class="formulaire-produit">
                    
                    <input type="hidden" name="id_maillot" value="<?php echo $id_choix; ?>">

                    <div class="groupe-input">
                        <label for="taille">Taille :</label>
                        <select name="taille" id="taille" required>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="2XL">2XL</option>
                        </select>
                    </div>

                    <div class="groupe-input">
                        <label for="flocage">Flocage :</label>
                        <input type="text" name="flocage" id="flocage" placeholder="Nom au dos (optionnel)">
                    </div>

                    <div class="groupe-input">
                        <label for="numero">Numéro :</label>
                        <input type="number" name="numero" id="numero" placeholder="Ex: 10 (optionnel)" min="1" max="99">
                    </div>

                    <div class="bas-formulaire">

                        <div class="groupe-input quantite-box">
                            <label for="quantite">Quantité :</label>
                            <input type="number" name="quantite" id="quantite" value="1" min="1" max="99" required>
                        </div>
                        
                        <button type="submit" class="bouton-panier">Ajouter au panier</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <?php require_once("../includes/footer.php"); ?>
    
</body>
</html>