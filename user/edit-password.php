<?php 
    session_start();

    $user = $_SESSION['user'];
    
    require_once('../bdd/connect_db.php');

    if (isset($_POST['password-edit'],$_POST['password'])) {
        
        $password = mysqli_real_escape_string($con, $_POST['password']); 
        $password_edit = mysqli_real_escape_string($con, $_POST['password-edit']); 

        $result = mysqli_query($con,"SELECT user FROM user WHERE user = '$user' AND mdp = '$password'");

        if (mysqli_fetch_array($result)) {

                mysqli_query($con,"UPDATE user SET mdp = '$password_edit' WHERE user = '$user'"); 

                $edit_success = "Password has been change";

                header("location: ../index.php?edit-success=$edit_success");
        } else {
            $edit_fail = "Wrong password !";

            header("location: settings.php?edit-fail=$edit_fail");
        }
    } else {
        header('location: ../index.php');
    }

?>