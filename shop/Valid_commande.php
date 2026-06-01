<?php 
    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: ../index.php');
        exit();
    }

    require_once("../bdd/connect_db.php");

    $id_user = $_SESSION['id_user'];
    $Nom_commande=$_POST['nom_commande'];
    $result = mysqli_query($con, "Select id_maillot, Taille, quantite, flocage, Numero FROM panier Where id_user= '$id_user' ");
    mysqli_query($con, "insert into commande (id_user,nom_commande) VALUES ('$id_user', '$Nom_commande')" );
    $result2 = mysqli_query($con, "Select id_commande FROM commande Where id_user= '$id_user' AND nom_commande='$Nom_commande' " );
    
    
    if ($commande=mysqli_fetch_array($result2)){
        
        $id_commande=$commande['id_commande'];

            while ($injection=mysqli_fetch_array($result)){
            $id_maillot=$injection['id_maillot'];
            $taille=$injection['Taille'];
            $quantite=$injection['quantite'];
            $flocage=$injection['flocage'];
            $Numero=$injection['Numero'];

            mysqli_query($con, "insert into historique_commande (id_commande, id_maillot, Taille, quantite, flocage, Numero) VALUES ('$id_commande', '$id_maillot', '$taille', '$quantite', '$flocage', '$Numero')");
            mysqli_query($con, "delete from panier where id_user='$id_user'");

    
    }
    }

    header('location: panier.php');
    


?>  