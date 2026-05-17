<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: ../index.php');
        exit();
    }

    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title> SHOP2MAILLOTS { Page d'acceuil }  </title>
        <link rel="stylesheet" href="../ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
    </head>
    <body>
        <?php require_once '../includes/header.php'; ?>   

        <?php 
                if (isset($_GET['edit-success'])) {
                    echo "<p>".$_GET['edit-success']."</p>";
                }
        ?>

        <div>
            <h2> Profil </h2>
            <hr>
            <?php echo "<p> Welcome back"." $user "."!</p>"; ?>
        </div>

        <p>@Fares|Yanis - 2026</p>
        
        <?php require_once '../includes/footer.php'; ?>
    </body>
</html>