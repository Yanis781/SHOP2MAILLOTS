<?php
    if (isset($_GET['message']))
        $message = $_GET['message'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title> BlackBox_iut { Register } </title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>Welcome to The BlackBox_iut</h1>    

        <div>
            <h2> Register </h2>
            <hr>
            <form method="post" action="register_db.php">
                Username :
                <input type="text" name="new_user" required><br>
                Password :
                <input type="password" name="new_password" required><br>
                <button type="submit">Register</button><br>
            </form><br>

            <a href="index.php">have already an account ?</a>

            <?php

                if (isset($message)) 
                    echo "<p>".$message."</p>";

            ?>
        </div>

        <p>@Fares - 2026</p>
    </body>
</html>