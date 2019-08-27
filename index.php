<?php ob_start();
session_start();
require_once "includes/db.php";
require_once "includes/functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Front End</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class='front-end'>
    <?php

if (isset($_SESSION['login'])) {
    echo "<div>you are Logged in<a href='logout.php'>Logout</a></div>";
} else if (isAlreadyLoggedIn()) {
    echo "<div>Welcome back {$_SESSION['name']} You are logged in <a href='logout.php'>Logout</a></div>";
} else {
    echo "<div>you are not Logged in<a href='login.php'>Login now</a></div>";

}
?>

</body>
</html>