<?php

    session_start();

    //present dans tout les fichier histoire de pourvoir eviter les erreur d'ajout a la bdd et access a des page non accesible.
    /* -----  VERIF ET REDIRECTION DU USER POUR VOIR SI C L'ADMIN OU PAS ----- */

    if ( isset($_SESSION['user']) ) {

        header('location: shop/home.php');
        exit();

    }

    if ( isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) {

        header('location: ../admin/dashboard.php');
        exit();

    }

    /* ------------------------------------------------------------------------ */
    /* -----  MESSAGE D'ERREUR/SUCCES ----- */

    if ( isset($_GET['message']) )
        $message = $_GET['message'];

    /* ------------------------------------ */

?>

<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SHOP2MAILLOTS { Register }</title>

        <link rel="stylesheet" href="../ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">

    </head>

    <body class="page-login">

        <!---- ENTETE HAUT DE PAGE ---->

        <header class="banniere-login">

            <h2>SHOP2MAILLOTS</h2>

        </header>

        <!----------------------------->

        <div class="conteneur-login">

            <h1>CRÉER UN COMPTE</h1> 

            <!---- FORMULAIRE INSCRIPTION ---->

            <form method="post" action="register_db.php">

                <input type="text" name="new_user" class="input-login" placeholder="Identifiant *" 
                    minlength="4" maxlength="16" 
                    title="L'identifiant doit faire entre 4 et 16 caractères." required>

                <input type="password" name="new_password" class="input-login" placeholder="Mot de passe *" 
                    pattern="(?=.*[A-Z]).{4,}" 
                    title="Le mot de passe doit contenir au moins 4 caractères et une majuscule." required>
                
                <div class="consignes-formulaire">
                    <p><strong>Critères requis :</strong></p>
                    <ul>
                        <li><strong>Identifiant :</strong> entre 4 et 16 caractères.</li>
                        <li><strong>Mot de passe :</strong> minimum 4 caractères, dont au moins 1 majuscule.</li>
                    </ul>
                </div>

                <div class="actions-login">
                    <button type="submit" class="bouton-login">S'INSCRIRE</button>
                </div>

            </form>

            <!------------------------------->
            <!-- REDIRECTION PAGE CONNEXION -->

            <div class="liens-bas-login">
                <a href="../index.php" class="lien-secondaire">Déjà un compte ? Se connecter</a>
            </div>

            <!------------------------------->
            <!--- AFFICHAGE ERREUR ---->

            <div class="messages-alerte">

                <?php

                    if ( isset($message) ) 
                        echo "<p class='alerte'>" . $message . "</p>";

                ?>
                
            </div>

            <!------------------------->

        </div>

        <!--- TEXTE PAS DE PAGE ---->

        <footer>
            <p class="copyright-login">2026 - Fares | Yanis - Tous droits réservés.</p>
        </footer>

        <!-------------------------->


    </body>

</html>