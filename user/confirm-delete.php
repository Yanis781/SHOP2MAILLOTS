<?php 
    session_start();

    $user = $_SESSION['user'];

    require_once('../bdd/connect_db.php');

    /*--- VERIF SI LA VARAIBLE PASSWORD A IEN ETAIT ENVOYER DEPUIS LE FORMULAIRE ---*/

    if ( isset( $_POST['password'] ) ) {
        
        $password = mysqli_real_escape_string( $con, $_POST['password'] ); 
        
        // --- REQUETTE POUR VERIF SI LE MDP EST BON ---
        $result = mysqli_query( $con, "SELECT nom_user FROM user WHERE nom_user = '$user' AND mdp = '$password'" );


        // --- CAS SI LE MDP EST BON ---
        if ( mysqli_fetch_array( $result ) ) {

            mysqli_query( $con, "DELETE FROM user WHERE nom_user = '$user'" ); 

            $delete_success = "Account delete";

            header("location: ../auth/logout.php?edit-success=$delete_success");
            exit();

        // --- CAS SI LE MDP EST FAUX ---
        } else {

            $delete_fail = "Wrong password !";

            header("location: delete-account.php?delete-fail=$delete_fail");
            exit();

        }
    
    // --- CAS SI IL N'AS PAS EU DE VARIABLE ENVOYER PAR LE FORMULAIRE ---
    } else {

        header('location: ../index.php');
        exit();
    }

    /*-------------------------------------------------------------------------------*/

?>