<?php
    session_start();

    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title> BlackBox_iut { Home }  </title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>BlackBox Iut Dashboard</h1>    

        <?php 
                if (isset($_GET['edit-success'])) {
                    echo "<p>".$_GET['edit-success']."</p>";
                }
        ?>

        <a href="settings.php">Make some modification on youre profile ?</a><br>
        <a href="logout.php">Logout ?</a>

        <div>
            <h2> Profile </h2>
            <hr>
            <?php echo "<p> Welcome back"." $user "."!</p>"; ?>
        </div>

        <div>
            <h2> Tel us what you think </h2>
            <hr>
            <form method="post" action="message.php">
                <input type="text" size="100" placeholder="Typpe just here" required><br>
                <button type="submit">Send</button> 
            </form>
        </div>

        <p>@Fares - 2026</p>
    </body>
</html>