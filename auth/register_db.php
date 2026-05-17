<?php

    require_once('../bdd/connect_db.php');

    if (isset($_POST['new_user'],$_POST['new_password'])){

        $new_user = mysqli_real_escape_string($con, $_POST['new_user']); 
        $new_password = mysqli_real_escape_string($con, $_POST['new_password']); 

        $result = mysqli_query($con,"SELECT user FROM user WHERE user = '$new_user'");

        if (mysqli_fetch_array($result)) {

            $message = "Cet utilisateur existe déja !";

            header("Location: register.php?message=$message");

        } else {

            mysqli_query($con,"INSERT INTO user (user,mdp) VALUES ('$new_user','$new_password')");

            $message = "Compte Créer !";

            header("Location: ../index.php?message=$message");

        }

        mysqli_close($con);

    } else {
        header("Location: ../index.php");
    }
?>