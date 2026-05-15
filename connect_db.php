<?php

    $db = "blackbox_iut";
    $con = mysqli_connect("localhost","root","",$db); 

    echo "<h1>Connection succes </h1>"; 

    if ( mysqli_connect_errno() ) { 
        echo "<h1>Failed to connect to MySQL: " . mysqli_connect_error()." </h1>"; 
    }

?>