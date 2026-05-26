<?php 
    session_start(); 
     
    $_SESSION = array(); 
     
    session_destroy(); 

    if (isset($_GET['edit-success'])){
        $message = $_GET['edit-success'];
        header("location: ../index.php?edit-success='$message'");
    } else {
        header('location: ../index.php');
    }
        
?>