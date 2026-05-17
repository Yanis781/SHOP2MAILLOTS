<?php
    if (isset($_GET['message']))
        $message = $_GET['message'];

    if (isset($_GET['error_login']))
        $error_login = $_GET['error_login'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title> SHOP2MAILLOTS { Login } </title>
        <link rel="stylesheet" href="ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="ressources/images/favicon.ico">
    </head>
    <body class="page-login">
        
        <header class="banniere-login">
            <h2>SHOP2MAILLOTS</h2>
        </header>

        <div class="conteneur-login">
            <h1>SE CONNECTER</h1> 
            
            <form method="post" action="auth/verif_login.php">     
                <input type="text" name="user" class="input-login" placeholder="Identifiant *" required>
                <input type="password" name="password" class="input-login" placeholder="Mot de passe *" required>
                
                <div class="actions-login">
                    <button type="submit" class="bouton-login">SE CONNECTER</button>
                </div>
            </form>

            <div class="liens-bas-login">
                <a href="auth/register.php" class="lien-secondaire">Créer un compte</a>
            </div>

            <div class="messages-alerte">
                <?php
                    if (isset($message)) 
                        echo "<p class='alerte'>".$message."</p>";

                    if (isset($error_login)) {
                        echo "<p class='alerte'>".$error_login."</p>";
                    }

                    if (isset($_GET['edit-success'])) {
                        echo "<p class='succes'>".$_GET['edit-success']."</p>";
                    }

                    if (isset($_GET['delete-success'])) {
                        echo "<p class='succes'>".$_GET['delete-success']."</p>";
                    }
                ?>
            </div>
        </div>

        <p class="copyright-login">2026 - Fares | Yanis - Tous droits réservés.</p>
    </body>
</html>