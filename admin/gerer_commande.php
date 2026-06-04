<?php 

    session_start();

    if ( !isset( $_SESSION['user'] ) || $_SESSION['user'] != 'Admin' ) {

        header('location: ../index.php');
        exit();

    }

    require_once("../bdd/connect_db.php");

    if ( isset($_POST['status']) || isset($_POST['supprimer'] ) ) {

        if ( isset( $_POST['status'], $_POST['id_commande'] ) ) {

            $id_commande = $_POST['id_commande'];
            $statut = $_POST['status'];

            $req_update_statut = mysqli_query($con, "UPDATE commande SET statut = '$statut' WHERE id_commande = '$id_commande' ;");

            $edit_succes = "Statut modifier !";

            header("location: dashboard.php?edit-succes='$edit_succes'");
            exit();

        }

        if ( isset( $_POST['supprimer'], $_POST['id_commande'] ) ) {

            $id_commande = $_POST['id_commande'];

            mysqli_query( $con, "DELETE FROM  historique_commande WHERE id_commande = '$id_commande' ");
            mysqli_query( $con, "DELETE FROM  commande WHERE id_commande = '$id_commande' ");

            $edit_succes = "Commande supprimer !";

            header("location: dashboard.php?edit-succes='$edit_succes'");
            exit();

        }

    } else {

        header("location: dashboard.php");
        exit();
        
    }





?>