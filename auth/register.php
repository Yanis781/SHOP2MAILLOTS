<?php
    if (isset($_GET['message']))
        $message = $_GET['message'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title> SHOP2MAILLOTS { Register } </title>
        <link rel="stylesheet" href="../ressources/css/styles.css">
    </head>
    <body class="page-login">

        <header class="banniere-login">
            <h2>SHOP2MAILLOTS</h2>
        </header>

        <div class="conteneur-login">
            <h1>CRÉER UN COMPTE</h1> 

            <form method="post" action="register_db.php">
                <input type="text" name="new_user" class="input-login" placeholder="Identifiant *" required>
                <input type="password" name="new_password" class="input-login" placeholder="Mot de passe *" required>
                
                <div class="actions-login">
                    <button type="submit" class="bouton-login">S'INSCRIRE</button>
                </div>
            </form>

            <div class="liens-bas-login">
                <a href="../index.php" class="lien-secondaire">Déjà un compte ? Se connecter</a>
            </div>

            <div class="messages-alerte">
                <?php
                    if (isset($message)) 
                        echo "<p class='alerte'>".$message."</p>";
                ?>
            </div>
        </div>

        <p class="copyright-login">@Fares|Yanis - 2026</p>
    </body>
</html>