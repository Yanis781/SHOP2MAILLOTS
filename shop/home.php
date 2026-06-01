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
            <h1 class="titre-page"> Page d'acceuil </h1>

            <div class="zone-recherche-catalogue">
                <form method="get" action="catalogue.php" class="barre-recherche">
                    <input type="text" class="input-recherche" placeholder="Rechercher un maillot..." name="recherche"s>
                    <button class="bouton-recherche" type="submit">Rechercher</button>
                </form>
            </div>

            <hr>

            <?php echo "<p> Welcome back"." $user "."!</p>"; ?>

        </div>

        <?php require_once '../includes/footer.php'; ?>
    </body>
</html>