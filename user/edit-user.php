<?php 
    session_start();

    $user = $_SESSION['user'];
    
    require_once('../bdd/connect_db.php');

    /* ---  VERIF DES VARIABLE POUR CHANGEMENT DE USER --- */

    if ( isset( $_POST['user-edit'], $_POST['password'] ) ) {

        /* ----- EVITER L'INJECTION SQL ----- */
        
        $user_edit = mysqli_real_escape_string( $con, $_POST['user-edit'] ); 
        $password = mysqli_real_escape_string( $con, $_POST['password'] ); 

        /* ---------------------------------- */

        // --- REQUETE POUR VERIF SI LE MDP DONNER EST CORRECTE ----
        $result = mysqli_query( $con, "SELECT nom_user FROM user WHERE nom_user = '$user' AND mdp = '$password'" );

        // --- CAS SI LE MDP EST CORRECTE --- 
        if ( mysqli_fetch_array( $result ) ) {

            // --- REQUETE POUR VERIF SI UN AUTRE NOM D'USER N'EXISTE PAS ----
            $result2 = mysqli_query( $con,"SELECT nom_user FROM user WHERE nom_user = '$user_edit'" );


            // --- CAS SI LE NEW USER EXISTE PAS --- 
            if ( !mysqli_fetch_array( $result2 ) ) {

                mysqli_query( $con, "UPDATE nom_user SET user = '$user_edit' WHERE nom_user = '$user'" ); 

                $_SESSION['user'] = $user_edit;

                $edit_success = "Le Nom d'utilisateur à bien été changer.";

                header("location: ../shop/home.php?edit-success=$edit_success");
                exit();


            // --- CAS SI LE NEW USER EXISTE ---     
            } else {

                $edit_fail = "Ce nom d'utilisateur existe déja !";

                header("location: settings.php?edit-fail=$edit_fail");
                exit();

            }

        // --- CAS SI LE MDP DONNER EST MAUVAIS --- 
        } else {

            $edit_fail = "Mauvais password !";

            header("location: settings.php?edit-fail=$edit_fail");
            exit();

        }
    
    // --- CAS SI IL N'AS EU DE VARIABLE ENVOYER PAR LE FORMULAIRE ---
    } else {

        header('location: ../index.php');
        exit();

    }

    /* -------------------------------------------------------*/

?>

