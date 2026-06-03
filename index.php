<?php

    session_start();

    //present dans tout les fichier histoire de pourvoir eviter les erreur d'ajout a la bdd et access a des page non accesible.
    /* -----  VERIF ET REDIRECTION DU USER POUR VOIR SI C L'ADMIN OU PAS ----- */
    
    if ( isset($_SESSION['user']) ) {

        header('location: shop/home.php');
        exit();

    }

    /* ------------------------------------------------------------------------ */
    /* -----  MESSAGE D'ERREUR/SUCCES ----- */

    if ( isset($_GET['message']) )
        $message = $_GET['message'];

    if ( isset($_GET['error_login']) )
        $error_login = $_GET['error_login'];

    /* ----------------------------- */

?>

<!DOCTYPE html>
<html>

    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SHOP2MAILLOTS { Register }</title>

        <link rel="stylesheet" href="ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="ressources/images/favicon.ico">

    </head>

    <body class="page-login">
        
        <!---- ENTETE HAUT DE PAGE ---->

        <header class="banniere-login">

            <h2>SHOP2MAILLOTS</h2>

        </header>

        <!-------------------------------->

        

        <div class="conteneur-login">

            <h1>SE CONNECTER</h1> 
            
            <!---- FORMULAIRE CONNEXION ---->

            <form method="post" action="auth/verif_login.php">

                <input type="text" name="user" class="input-login" placeholder="Identifiant *" required>
                <input type="password" name="password" class="input-login" placeholder="Mot de passe *" required>
                
                <div class="actions-login">
                    <button type="submit" class="bouton-login">SE CONNECTER</button>
                </div>

            </form>

            <!-------------------------------->
            <!-- REDIRECTION CREATION COMPTE -->

            <div class="liens-bas-login">
                <a href="auth/register.php" class="lien-secondaire">Créer un compte</a>
            </div>

            <!-------------------------------->
            <!--- AFFICHAGE SUCCESS/ERREUR ---->

            <div class="messages-alerte">
                <?php

                    if ( isset($message) ) 
                        echo "<p class='alerte'>" . $message . "</p>";

                    if ( isset($error_login) )
                        echo "<p class='alerte'>" . $error_login . "</p>";

                    if ( isset($_GET['edit-success']) )
                        echo "<p class='succes'>" . $_GET['edit-success'] . "</p>";

                    if (isset($_GET['delete-success']))
                        echo "<p class='succes'>" . $_GET['delete-success'] . "</p>";

                ?>
            
            <!---------------------------------->

            </div>
        </div>

        <!--- TEXTE PAS DE PAGE ---->

        <footer>
            <p class="copyright-login">2026 - Fares | Yanis - Tous droits réservés.</p>
        </footer>

        <!-------------------------->

    </body>

</html>