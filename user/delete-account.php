<?php

    session_start();

    //present dans tout les fichier histoire de pourvoir eviter les erreur d'ajout a la bdd et access a des page non accesible.
    /* -----  VERIF ET REDIRECTION DU USER POUR VOIR SI C L'ADMIN OU PAS ----- */

    if ( !isset($_SESSION['user']) || $_SESSION['role'] == "admin" ) {

        header('location: ../index.php');
        exit();

    }

    /* ---------------------------------------------------------------------- */

?>
<!DOCTYPE html>
<html>

    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SHOP2MAILLOTS { Supprimer le compte }</title>

        <link rel="stylesheet" href="ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="ressources/images/favicon.ico">

    </head>

    <body>

        <?php require_once '../includes/header.php'; ?>

        <div class="conteneur-page">
            
            <div class="carte-parametre carte-danger zone-centree">

                <h1>⚠️ ACTION IRRÉVERSIBLE</h1>

                <hr class="separateur">

                <p class="info-texte">Tu es sur le point de supprimer définitivement ton compte SHOP2MAILLOTS.</p>

                <!-- AFFICHAGE MESSAGE ERREUR -->

                <div class="messages-alerte">

                    <?php 

                        if ( isset( $_GET['delete-fail'] ) )
                            echo "<p class='alerte'>" . $_GET['delete-fail'] . "</p>";
                    
                    ?>

                </div>

                <!------------------------------>
                <!-- FORMULAIRE POUR CONFORMER LA SUPPRESSION DU COMPTE -->

                <form method="post" action="confirm-delete.php">

                    <input type="password" name="password" class="input-login" placeholder="Mot de passe actuel pour confirmer *" required>

                    <button type="submit" class="bouton-login bouton-rouge">CONFIRMER LA SUPPRESSION</button>
                    
                </form>

                <!------------------------------>
                <!-- REDIRECTION AUX PARAMETRE DU COMPTE -->
                
                <div class="liens-bas-login">
                    <a href="settings.php" class="lien-secondaire">Annuler et revenir aux paramètres</a>
                </div>

                <!------------------------------>

            </div>

        </div>

        <?php require_once '../includes/footer.php'; ?>

    </body>

</html>