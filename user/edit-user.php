<?php 
    session_start();

    $user = $_SESSION['user'];
    
    require_once('connect_db.php');

    if (isset($_POST['user-edit'],$_POST['password'])) {
        
        $user_edit = mysqli_real_escape_string($con, $_POST['user-edit']); 
        $password = mysqli_real_escape_string($con, $_POST['password']); 

        $result = mysqli_query($con,"SELECT user FROM user WHERE user = '$user' AND password = '$password'");

        if (mysqli_fetch_array($result)) {

            $result2 = mysqli_query($con,"SELECT user FROM user WHERE user = '$user_edit'");

            if (!mysqli_fetch_array($result2)) {

                mysqli_query($con,"UPDATE user SET user = '$user_edit' WHERE user = '$user'"); 

                $_SESSION['user'] = $user_edit;

                $edit_success = "User has been change";

                header("location: home.php?edit-success=$edit_success");
            } else {
                $edit_fail = "This user already exist !";

                header("location: settings.php?edit-fail=$edit_fail");
            }
        } else {
            $edit_fail = "Wrong password !";

            header("location: settings.php?edit-fail=$edit_fail");
        }
    } else {
        header('location: index.php');
    }

?>

