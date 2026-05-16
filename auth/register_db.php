<?php

    require_once('../bdd/connect_db.php');

    if (isset($_POST['new_user'],$_POST['new_password'])){

        $new_user = mysqli_real_escape_string($con, $_POST['new_user']); 
        $new_password = mysqli_real_escape_string($con, $_POST['new_password']); 

        $result = mysqli_query($con,"SELECT user FROM user WHERE user = '$new_user'");

        if (mysqli_fetch_array($result)) {

            $message = "this user already exist !";

            header("Location: register.php?message=$message");

        } else {

            mysqli_query($con,"INSERT INTO user VALUES ('$new_user','$new_password')");

            $message = "Account created !";

            header("Location: ../index.php?message=$message");

        }

        mysqli_close($con);

    } else {
        echo "<h1>access denided.</h1>";
        echo "<a href='../index.php'>return to connexion.</a>";
    }
?>