<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: ../index.php');
        exit();
    }

    require_once("../bdd/connect_db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../ressources/css/styles.css">
    <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
    <title>DSHOP2MAILLOTS { Panier }</title>
</head>
<body>
    
    <?php require_once("../includes/header.php"); ?>

    <?php require_once("../includes/footer.php"); ?>

</body>
</html>