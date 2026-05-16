<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> SHOP2MAILLOTS { Delete } </title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>⚠️ Cette action est irreversible.</h1><br>
    <div>
        <?php 
                if (isset($_GET['delete-fail'])) {
                    echo "<p>".$_GET['delete-fail']."</p>";
                }
        ?>
        <h2>Supprimer le compte ?</h2>
        <form method="post" action="confirm-delete.php">
            Mot de passe actuelle pour confirmer : 
            <input type="password" name="password" require><br>
            <button type="submit">Confirmer</button>
        </form>
        <a href="settings.php">Annuler et revenir aux Paramettre.</a>
    </div>
</body>
</html>