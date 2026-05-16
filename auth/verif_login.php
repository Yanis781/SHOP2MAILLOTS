<?php

    session_start();

    require_once('../bdd/connect_db.php');

    if (isset($_POST['user'],$_POST['password'])) {

        $user = mysqli_real_escape_string($con, $_POST['user']); 
        $password = mysqli_real_escape_string($con, $_POST['password']); 

        $result = mysqli_query($con,"SELECT * FROM user WHERE user = '$user' AND mdp = '$password'");

        if (mysqli_fetch_array($result)) {

            $_SESSION['user'] = $user;
            $_SESSION['password'] = $password;

        } else {
            $message = "Wrong Password or User";

            header("location: ../index.php?error_login=$message");
        }
    } else {

        echo "<h1> Accès interdit.</h1>";
        echo "<a href='../index.php'>Revenir a la page de connection. </a>";
    }

?>