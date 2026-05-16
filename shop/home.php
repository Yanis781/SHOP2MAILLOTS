<?php
    session_start();

    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title> SHOP2MAILLOTS { Page d'acceuil }  </title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>SHOP2MAILLOTS Page d'acceuil</h1>    

        <?php 
                if (isset($_GET['edit-success'])) {
                    echo "<p>".$_GET['edit-success']."</p>";
                }
        ?>

        <a href="../user/settings.php"> Modifier votre profil !</a><br>
        <a href="../auth/logout.php">Deconexion!</a>

        <div>
            <h2> Profil </h2>
            <hr>
            <?php echo "<p> Welcome back"." $user "."!</p>"; ?>
        </div>

        <div>
            <h2> Dites nous ce que vous pensez ! </h2>
            <hr>
            <form method="post" action="message.php">
                <input type="text" size="100" placeholder="Typpe just here" required><br>
                <button type="submit">Send</button> 
            </form>
        </div>

        <p>@Fares - 2026</p>
    </body>
</html>