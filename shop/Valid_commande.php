<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: ../index.php');
        exit();
    }

    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        header('location: ../admin/dashboard.php');
        exit();
    }

    require_once("../bdd/connect_db.php");

    


?>  