<?php 
    session_start();

    /* -----  VERIF ET REDIRECTION DU USER POUR VOIR SI C L'ADMIN OU PAS ----- */

    if ( !isset( $_SESSION['user'] ) ) {

        header('location: ../index.php');
        exit();

    }

    /* -----  SI user = admin, on le redirige vers le dashborad (La page d'administration du site) ----- */

    if ( isset( $_SESSION['role'] ) && $_SESSION['role'] == 'admin' ) {

        header('location: ../admin/dashboard.php');
        exit();

    }
    /* ------------------------------------------------------------------------ */


    require_once("../bdd/connect_db.php");

    /* ----- ON DEFINIE DES VARIABLE POUR LE PANIER ----- */

    if ( isset( $_POST['id_maillot'], $_POST['quantite'],$_POST['taille'] ) ) {
            
            $id_user = $_SESSION['id_user'];
            $id_maillot = $_POST['id_maillot']; 
            $quantite = $_POST['quantite'];
            $taille = mysqli_real_escape_string( $con, $_POST['taille'] );

            /*--------- VERIF SI LE NUMERO ET ET LE FLOCAGE ONT ETE RESEIGNER OU PAS -------*/

            if ( !empty( $_POST['flocage'] ) )
                $flocage = mysqli_real_escape_string( $con, $_POST['flocage'] );
            else 
                $flocage = "";

            /*
            if (!empty($_POST['numero'])) {
                $numero = mysqli_real_escape_string($con, $_POST['numero']);
            } else {
                $numero = "NULL";
            } */
   
            if ( isset( $_POST['numero'] ) && $_POST['numero'] != '' )
                $numero = mysqli_real_escape_string( $con, $_POST['numero'] );
            else 
                $numero = "";
            

            /*-------- ON INSERRE LES DONNEES DANS LA TABLE PANIER ------*/

            $result = mysqli_query( $con, "INSERT INTO Panier (id_user, id_maillot, quantite, numero, taille, flocage) 
                VALUES ($id_user, $id_maillot, $quantite, '$numero', '$taille', '$flocage')" );

            header('location: panier.php');
            exit();

    } else {

        header('location: product.php');
        exit();
        
    }

?>