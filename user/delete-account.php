<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: ../index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title> SHOP2MAILLOTS { Delete } </title>
    <link rel="stylesheet" href="../ressources/css/styles.css">
</head>
<body>
    <?php require_once '../includes/header.php'; ?>

    <div class="conteneur-page">
        
        <div class="carte-parametre carte-danger zone-centree">
            <h1>⚠️ ACTION IRRÉVERSIBLE</h1>
            <hr class="separateur">
            <p class="info-texte">Tu es sur le point de supprimer définitivement ton compte SHOP2MAILLOTS.</p>

            <div class="messages-alerte">
                <?php 
                    if (isset($_GET['delete-fail'])) {
                        echo "<p class='alerte'>".$_GET['delete-fail']."</p>";
                    }
                ?>
            </div>

            <form method="post" action="confirm-delete.php">
                <input type="password" name="password" class="input-login" placeholder="Mot de passe actuel pour confirmer *" required>
                <button type="submit" class="bouton-login bouton-rouge">CONFIRMER LA SUPPRESSION</button>
            </form>
            
            <div class="liens-bas-login">
                <a href="settings.php" class="lien-secondaire">Annuler et revenir aux paramètres</a>
            </div>
        </div>

    </div>

    <?php require_once '../includes/footer.php'; ?>
</body>
</html>