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
        $id_choix = $_GET['id-maillot']; 
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

    <h1 class="titre-page">MAILLOT CHOISI</h1>

    <div>
    <?php echo '<img src="../ressources/images/'.$maillot['fichier_image'].'" alt="'.$maillot['nom_maillot'].'">'; ?>
    </div>

    <div>
        <form method="post" action="ajout_panier.php">

            <input type="hidden" name="id_maillot" value="<?php echo $id_choix; ?>">

            <input type="text" name="flocage" placeholder="Flocage (optionnel)">

            <input type="number" name="numero" placeholder="Numéro (optionnel)" min="1" max="99">

            <label for="quantite">Quantité :</label>
            <input type="number" name="quantite" id="quantite" value="1" min="1" max="99" required>

            <select name="taille" id="taille" required>
                <option value="XS">XS</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="2XL">2XL</option>
            </select>

            <button type="submit">Ajouter au panier</button>
        </form>
    </div>

    <?php require_once("../includes/footer.php"); ?>
    
</body>
</html>