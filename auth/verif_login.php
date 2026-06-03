<?php

    session_start();

    require_once('../bdd/connect_db.php');

    /* -----  VERIF DES VARIBALE DU FORMULAIRE ----- */

    if ( isset($_POST['user'], $_POST['password']) ) {

        /* ----- EVITER L'INJECTION SQL ----- */

        $user = mysqli_real_escape_string($con, $_POST['user']); 
        $password = mysqli_real_escape_string($con, $_POST['password']);

        /* ---------------------------------- */
        /* ----- VERIF SI LE USER/MDP CORRESPOND BIEN OU PAS ----- */

        $result = mysqli_query($con, "SELECT * FROM user WHERE nom_user = '$user' AND mdp = '$password'");

        if ( $donnees = mysqli_fetch_array($result) ) {

            /* ----- CREATION DE VARIABLE GLOBAL SESSION --- */
            //vont etre utiliser dans d'autre page pour par exemple correspondre un panier a un id-user.

            $_SESSION['user'] = $donnees['nom_user'];
            $_SESSION['id_user'] = $donnees['id_user'];
            $_SESSION['role'] = $donnees['role'];

            /* ---------------------------------- */

            header("location: ../shop/home.php");
            exit();

        } else {

            $message = "Mauvais nom d'utilisateur ou mdp...";

            header("location: ../index.php?error_login=$message");
            exit();

        }

    } else {

        header("Location: ../index.php");
        exit();

    }

?>