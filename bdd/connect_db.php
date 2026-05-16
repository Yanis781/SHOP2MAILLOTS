<?php

    $db = "shop2maillots_db";
    $con = mysqli_connect("localhost","root","",$db); 

    if ( mysqli_connect_errno() ) { 
        echo "<h1>Connexion vers MySQL échoué: " . mysqli_connect_error()." </h1>"; 
    }

?>