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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOP2MAILLOTS { Choix Maillot }</title>
    <link rel="stylesheet" href="../ressources/css/styles.css">
    <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
</head>
<body>

    <?php require_once("../includes/header.php"); ?>

    <h1 class="titre-page">MAILLOTS CHOISI</h1>

    <div>
    <?php echo '<img src="../ressources/images/'.$maillot['fichier_image'].'" alt="'.$maillot['nom_maillot'].'"'; ?>
    </div>


    <?php require_once("../includes/footer.php"); ?>
    
</body>
</html>