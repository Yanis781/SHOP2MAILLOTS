<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> BlackBox_iut { Delete } </title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>⚠️ This action is irreversible.</h1><br>
    <div>
        <?php 
                if (isset($_GET['delete-fail'])) {
                    echo "<p>".$_GET['delete-fail']."</p>";
                }
        ?>
        <h2>Delete the account?</h2>
        <form method="post" action="confirm-delete.php">
            Current password to confirm: 
            <input type="password" name="password" require><br>
            <button type="submit">Confirm</button>
        </form>
        <a href="settings.php">Cancel and return to settings.</a>
    </div>
</body>
</html>