<?php

    session_start();

    require_once('connect_db.php');

    if (isset($_POST['user'],$_POST['password'])) {

        $user = mysqli_real_escape_string($con, $_POST['user']); 
        $password = mysqli_real_escape_string($con, $_POST['password']); 

        $result = mysqli_query($con,"SELECT * FROM user WHERE user = '$user' AND mdp = '$password'");

        if (mysqli_fetch_array($result)) {

            $_SESSION['user'] = $user;
            $_SESSION['password'] = $password;

            header("location: home.php");

        } else {
            $message = "Wrong Password or User";

            header("location: index.php?error_login=$message");
        }
    } else {

        echo "<h1> access denided.</h1>";
        echo "<a href='index.php'>return to connexion. </a>";
    }

?>