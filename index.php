<?php
    if (isset($_GET['message']))
        $message = $_GET['message'];

    if (isset($_GET['error_login']))
        $error_login = $_GET['error_login'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title> SHOP2MAILLOT { Login }  </title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1> Bienvenue !</h1>    

        <div>
            <h2> connect to your account </h2>
            <hr>
            <form method="post" action="auth/verif_login.php">     
                Username :
                <input type="text" name="user" required><br>
                Password :
                <input type="password" name="password" required><br>
                <button type="submit">Login</button><br>
            </form><br>

            <a href="auth/register.php">No account ?</a>
        </div>

        <hr>

        <div>
            <?php

                if (isset($message)) 
                    echo "<p style='color=red;'>".$message."</p>";

                if (isset($error_login)) {
                    echo "<p>".$error_login."</p>";
                }

                if (isset($_GET['edit-success'])) {
                    echo "<p>".$_GET['edit-success']."</p>";
                }

                if (isset($_GET['delete-success'])) {
                    echo "<p>".$_GET['delete-success']."</p>";
                }

            ?>
        </div>

        <p>@Fares|Yanis - 2026</p>
    </body>
</html>