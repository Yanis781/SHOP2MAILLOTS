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

    if (isset($_POST['id_maillot'],$_POST['quantite'],$_POST['taille'])) {
            
            $id_user = $_SESSION['id_user'];
            $id_maillot = $_POST['id_maillot']; 
            $quantite = $_POST['quantite'];
            $taille = mysqli_real_escape_string($con, $_POST['taille']);

            if (!empty($_POST['flocage'])) {
                $flocage = mysqli_real_escape_string($con, $_POST['flocage']);
            } else {
                $flocage = "";
            }

            if (!empty($_POST['numero'])) {
                $numero = mysqli_real_escape_string($con, $_POST['numero']);
            } else {
                $numero = "NULL";
            }

            $result = mysqli_query($con, "INSERT INTO Panier (id_user, id_maillot, quantite, numero, taille, flocage) 
                VALUES ($id_user, $id_maillot, $quantite, $numero, '$taille', '$flocage')");

            header('location: panier.php');

    } else {
        header('location: product.php');
    }

?>