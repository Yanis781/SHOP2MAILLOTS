<?php 

    session_start();

    /* -----  VERIF ET REDIRECTION DU USER POUR VOIR SI C L'ADMIN OU PAS ----- */

    if ( !isset( $_SESSION['user'] ) ) {

        header('location: ../index.php');
        exit();

    }

    require_once("../bdd/connect_db.php");


    if ( isset( $_POST['nom_commande'] ) ) {

        /*------ RECUPERATION DES DONNEES DU PANIER POUR LES AJOUTER DANS 'historique_commande' ET VIDER LE PANIER -----*/

        $id_user = $_SESSION['id_user'];
        $nom_commande = $_POST['nom_commande'];
        $result = mysqli_query( $con, "SELECT id_maillot, Taille, quantite, flocage, Numero FROM panier WHERE id_user= '$id_user' " );
        mysqli_query( $con, "INSERT INTO commande (id_user,nom_commande) VALUES ('$id_user', '$nom_commande')" );
        $result2 = mysqli_query( $con, "SELECT id_commande FROM commande WHERE id_user= '$id_user' AND nom_commande='$nom_commande' " );

        
        /*---- INSERTION ET SUPPRESSION DES DONNEES DANS LES TABLES 'historique_commande' ET 'panier' -----*/
        
        if ( $commande = mysqli_fetch_array( $result2 ) ) {
            
            $id_commande = $commande['id_commande'];

            while ( $injection = mysqli_fetch_array( $result ) ) {

                $id_maillot = $injection['id_maillot'];
                $taille = $injection['Taille'];
                $quantite = $injection['quantite'];
                $flocage = $injection['flocage'];
                $numero = $injection['Numero'];

                mysqli_query( $con, "INSERT INTO historique_commande (id_commande, id_maillot, Taille, quantite, flocage, Numero) VALUES ('$id_commande', '$id_maillot', '$taille', '$quantite', '$flocage', '$numero')" );
                mysqli_query( $con, "DELETE FROM panier WHERE id_user='$id_user'" );

            }

            header('location: index.php');
            exit();
            
        }

    } else {

        header('location: index.php');
        exit();

    }

?>  