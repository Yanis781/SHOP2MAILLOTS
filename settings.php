<?php
    session_start();
    
    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title> BlackBox_iut { settings }  </title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>BlackBox Iut Edit</h1>    

        <a href="home.php">Return home ?</a><br>

        <div>
            <?php 
                if (isset($_GET['edit-fail'])) {
                    echo "<p>".$_GET['edit-fail']."</p>";
                }
            ?>
            <h2>Change User ?</h2>
            <hr>
            <?php echo "Youre Username : " . $user . "."; ?>

            <form method="post" action="edit-user.php">
                New user : <br>
                <input type="text" name="user-edit" required><br>
                Recent Password (for verification) : <br>
                <input type="password" name="password" required><br>
                <button type="submit"> Change password </button>
            </form>
        </div>

        <div>
            <h2>Change Password ?</h2>
            <hr>
            <form method="post" action="edit-password.php">
                Recent Password : <br>
                <input type="password" name="password" required><br>
                New Password : <br>
                <input type="password" name="password-edit" required><br>
                <button type="submit"> Change password </button>
            </form>
        </div>

        <div>
            <h2>Deleted account ?</h2>
            <hr>
            <a href="delete-account.php">Delete account ?</a>
        </div>
        

        <p>@Fares - 2026</p>
    </body>
</html>