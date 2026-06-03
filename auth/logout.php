<?php 

    session_start(); 

    /* ---SUPPRESION DES VARIABLE GLOBAL SESSION POUR DECO L'USER ---*/
    
    $_SESSION = array(); 
     
    session_destroy(); 

    /* --- MESSAGE SUCCES ---*/
    // sert a envoyer un message vers la page de connexion pour le cas ou l'utilisateur supprime son compte our fait une modif (voir dossier '/user').

    if ( isset( $_GET['edit-success'] ) ) {

        $message = $_GET['edit-success'];
        
        header("location: ../index.php?edit-success='$message'");
        exit();

    } else {

        header('location: ../index.php');
        exit();

    }

    /* ---------------------*/
        
?>