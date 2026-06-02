<?php

    session_start();

    require_once('../bdd/connect_db.php');

    if (isset($_POST['user'],$_POST['password'])) {

        $user = mysqli_real_escape_string($con, $_POST['user']); 
        $password = mysqli_real_escape_string($con, $_POST['password']); 

        $result = mysqli_query($con,"SELECT * FROM User WHERE nom_user = '$user' AND mdp = '$password'");

        if ($donnees = mysqli_fetch_array($result)) {

            $_SESSION['user'] = $donnees['nom_user'];
            $_SESSION['id_user'] = $donnees['id_user'];
            $_SESSION['role'] = $donnees['role'];

            header("location: ../shop/home.php");

        } else {
            $message = "Wrong Password or User";

            header("location: ../index.php?error_login=$message");
        }
    } else {
        header("Location: ../index.php");
    }

?>