<?php

    session_start();

    //present dans tout les fichier histoire de pourvoir eviter les erreur d'ajout a la bdd et access a des page non accesible.
    /* -----  VERIF ET REDIRECTION DU USER POUR VOIR SI C L'ADMIN OU PAS ----- */
    
    if ( !isset( $_SESSION['user'] ) || $_SESSION['role'] == "admin" )  {

        header('location: ../index.php');
        exit();

    }

    /* -------------------------------------------------------------------- */

?>

<!DOCTYPE html>
<html>

    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SHOP2MAILLOTS { Paramètre }</title>

        <link rel="stylesheet" href="../ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">

    </head>

    <body>

        <?php require_once '../includes/header.php'; ?>

        <div class="conteneur-page">

            <h1 class="titre-page">MES PARAMÈTRES</h1>    

            <!---- AFFICHAGE MESSAGE ERREUR ---->

            <div class="messages-alerte">

                <?php 

                    if ( isset( $_GET['edit-fail'] ) ) {
                        echo "<p class='alerte'>" . $_GET['edit-fail'] . "</p>";
                    }

                ?>

            </div>

            <!---------------------------------->

            <!---- TOUT LES FORMULAIRE POUR MODIF/SUPP LE COMPTE ---->

            <div class="grille-parametres">

                <!---- FORMULAIRE MODIF USER ---->
                
                <div class="carte-parametre">

                    <h2>Nom d'utilisateur</h2>

                    <hr class="separateur">

                    <p class="info-texte">Ton nom actuel est : <strong><?php echo htmlspecialchars( $_SESSION['user'] ); ?></strong></p>

                    <form method="post" action="edit-user.php">

                        <input type="text" name="user-edit" class="input-login" placeholder="Nouveau nom d'utilisateur *" required>
                        <input type="password" name="password" class="input-login" placeholder="Mot de passe actuel *" required>

                        <button type="submit" class="bouton-login">Changer le nom</button>

                    </form>

                </div>

                <!------------------------------>
                <!---- FORMULAIRE MODIF MDP ---->

                <div class="carte-parametre">

                    <h2>Mot de passe</h2>

                    <hr class="separateur">

                    <form method="post" action="edit-password.php">

                        <input type="password" name="password" class="input-login" placeholder="Mot de passe actuel *" required>
                        <input type="password" name="password-edit" class="input-login" placeholder="Nouveau mot de passe *" required>
                        
                        <button type="submit" class="bouton-login">Changer de mot de passe</button>
                    
                    </form>
                </div>

                <!------------------------------>
                <!---- REDIRACTION PAGE CONFIRM ---->

                <div class="carte-parametre carte-danger">

                    <h2>supprimer le compte ?</h2>

                    <hr class="separateur">

                    <p class="info-texte">Attention, la suppression de ton compte est définitive et entraînera la perte de ton historique de commandes.</p>
                    <a href="delete-account.php" class="bouton-danger">Supprimer mon compte</a>

                </div>

                <!----------------------------------->

            </div>

            <!------------------------------------------------------->

        </div>

        <?php require_once '../includes/footer.php'; ?>

    </body>
    
</html>