<?php

    /* --- CONNEXION A LA BDD ---*/
    
    /* --- VARIABLE POUR INFO CONNEXION BDD (user,mdp) --- */
    // pour chnager de dommain user ou mdp si on change de serveur de bdd

    $domaine = "localhost";
    $user_db = "root";
    $mdp_db = "";
    $db = "shop2maillots_db";

    $con = mysqli_connect( $domaine, $user_db, $mdp_db, $db ); 

    /* ------------------------------------------------ */
    /* --- AFFICHAGE SI ERREUR ---*/

    if ( mysqli_connect_errno() ) {

        echo "<h1>Connexion vers MySQL échoué : " . mysqli_connect_error() . " </h1>"; 

    }

    /* -------------------------- */

?>