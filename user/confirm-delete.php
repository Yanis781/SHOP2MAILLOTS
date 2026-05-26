<?php 
    session_start();

    $user = $_SESSION['user'];

    require_once('../bdd/connect_db.php');

    if (isset($_POST['password'])) {
        
        $password = mysqli_real_escape_string($con, $_POST['password']);  

        $result = mysqli_query($con,"SELECT nom_user FROM user WHERE nom_user = '$user' AND mdp = '$password'");

        if (mysqli_fetch_array($result)) {

                mysqli_query($con,"DELETE FROM user WHERE nom_user = '$user'"); 

                $delete_success = "Account delete";
                header("location: ../auth/logout.php?edit-success=$delete_success");
        } else {
            $delete_fail = "Wrong password !";

            header("location: delete-account.php?delete-fail=$delete_fail");
        }
    } else {
        header('location: ../index.php');
    }

?>