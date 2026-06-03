<?php

    require_once('../bdd/connect_db.php');

    /* -----  VERIF DES VARIBALE DU FORMULAIRE ----- */

    if ( isset($_POST['new_user'], $_POST['new_password']) ){

        /* ----- EVITER L'INJECTION SQL ----- */

        $new_user = mysqli_real_escape_string($con, $_POST['new_user']); 
        $new_password = mysqli_real_escape_string($con, $_POST['new_password']);

        /* ------------------------------------ */
        /* ----- VERIF SI LE USER NEXISTE PAS DEJA ----- */

        $result = mysqli_query($con, "SELECT nom_user FROM user WHERE nom_user = '$new_user'");

        if (mysqli_fetch_array($result)) {

            $message = "Cet utilisateur existe déja !";

            header("Location: register.php?message=$message");
            exit();

        } else {

            mysqli_query($con, "INSERT INTO user (nom_user,mdp) VALUES ('$new_user','$new_password')");

            $message = "Compte Créer !";

            header("Location: ../index.php?message=$message");
            exit();

        }

        mysqli_close($con);

    } else {

        header("Location: ../index.php");
        exit();

    }

?>