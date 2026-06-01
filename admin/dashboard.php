<?php
    session_start();

    if (!isset($_SESSION['user']) || $_SESSION['user'] != 'Admin') {
        header('location: ../index.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> SHOP2MAILLOTS { Dashbord } </title>
    <link rel="stylesheet" href="../ressources/css/styles.css">
    <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">
</head>
<body>
    aaaa
</body>
</html>