<?php 

    session_start();

    $user = $_SESSION['user'];
    
    require_once('../bdd/connect_db.php');

    /* ---  VERIF DES VARIABLE POUR CHANGEMENT DE MDP --- */

    if (isset( $_POST['password-edit'], $_POST['password'] ) ) {

        /* ----- EVITER L'INJECTION SQL ----- */

        $password = mysqli_real_escape_string($con, $_POST['password']); 
        $password_edit = mysqli_real_escape_string($con, $_POST['password-edit']); 

        /* ---------------------------------- */

        // --- REQUETE POUR VERIF SI LE MDP DONNER EST CORRECTE ----
        $result = mysqli_query( $con, "SELECT nom_user FROM user WHERE nom_user = '$user' AND mdp = '$password'" );

        // --- CAS SI LE MDP EST BON (MODIF DU PASSWORD) ----
        if (mysqli_fetch_array($result)) {

                mysqli_query( $con, "UPDATE user SET mdp = '$password_edit' WHERE nom_user = '$user'" ); 

                $edit_success = "Le mot de passe à bien été chnager.";

                header("location: ../auth/logout.php?edit-success='$edit_success'");
                exit();

        // --- CAS SI LE MDP EST FAUX ---
        } else {

            $edit_fail = "Mauvais mot de passe...";

            header("location: settings.php?edit-fail=$edit_fail");
            exit();

        }

    // --- CAS SI IL N'AS PAS EU DE VARIABLE ENVOYER PAR LE FORMULAIRE ---
    } else {

        header('location: ../index.php');
        exit();

    }

    /* ------------------------------------------------- */

?>