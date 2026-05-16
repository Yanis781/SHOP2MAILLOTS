<?php
    session_start();
    
    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title> SHOP2MAILLOTS { Paramettre }  </title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>SHOP2MAILLOTS Paramettre</h1>    

        <a href="../shop/home.php">Revenir a la page d'accueil ?</a><br>

        <div>
            <?php 
                if (isset($_GET['edit-fail'])) {
                    echo "<p>".$_GET['edit-fail']."</p>";
                }
            ?>
            <h2>Changer le nom d'utilisateur ?</h2>
            <hr>
            <?php echo "Ton nom d'utilisateur actuelle est : " . $user . "."; ?>

            <form method="post" action="edit-user.php">
                New user : <br>
                <input type="text" name="user-edit" required><br>
                Recent Password (for verification) : <br>
                <input type="password" name="password" required><br>
                <button type="submit"> Change password </button>
            </form>
        </div>

        <div>
            <h2>Changer le Mot de passe ?</h2>
            <hr>
            <form method="post" action="edit-password.php">
                Mot de passe actuelle : <br>
                <input type="password" name="password" required><br>
                Nouveau mot de passe : <br>
                <input type="password" name="password-edit" required><br>
                <button type="submit"> Changer le Mot de passe </button>
            </form>
        </div>

        <div>
            <h2>Supprimer le compte ?</h2>
            <hr>
            <a href="delete-account.php">Delete account ?</a>
        </div>
        

        <p>@Fares - 2026</p>
    </body>
</html>