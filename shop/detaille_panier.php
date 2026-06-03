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
    
    

?>

<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SHOP2MAILLOTS { detaille panier }</title>
        
        <link rel="stylesheet" href="../ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">

    </head>

    <body>
    
        <?php require_once '../includes/header.php'; ?>

        <div class="conteneur-page">

            <h2 class="titre-page">detaille de la commande :</h2>

        </div>



        <?php require_once '../includes/footer.php'; ?>

    </body>

</html>