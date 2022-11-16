<?php
    session_start();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../indexstyles.css">
    <title>Your Account</title>
    <link rel="icon" type="image/x-icon" href="/Website Logos/favicon.ico">
</head>
<body  class="pageBody">
    <body>
        <?php include("../nav_bar.php"); ?>
    </body>

    <?php
    $username = $_GET["username"];
    $userID = $_GET["userID"];
    if(isset($_SESSION["username"]) && $_SESSION["username"] == $username && $_SESSION["userID"] == $userID) {
        //All the fun account info stuff goes here
        echo $username . "'s page ";
    } else if(isset($_SESSION["username"]) && $_SESSION["username"] != $username && $_SESSION["userID"] != $userID) {
        echo "You do not have access to this page!";
    } else {
        echo "Please log in to view this page!";
    }
    ?>
    <?php include("../footer.php"); ?>
</body>
</html>