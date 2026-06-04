
<?php 

    session_start();

    /* -----  VERIF ET REDIRECTION DU USER POUR VOIR SI C L'ADMIN OU PAS ----- */

    if ( !isset( $_SESSION['user'] ) ) {

        header('location: ../index.php');
        exit();

    }

    require_once("../bdd/connect_db.php");

    $id_panier = $_POST['maillot_supp'];

    mysqli_query($con, "DELETE FROM panier WHERE id_panier='$id_panier'");
    
    header('location: panier.php');
            exit();
            
   ?>