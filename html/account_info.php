<?php
    session_start();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexstyles.css">
    <title>Your Account</title>
</head>
<body  class="pageBody">
    <body>
        <?php include("nav_bar.php"); ?>
    </body>

    <?php
        $username = $_GET["username"];
        echo $username . "'s page";
    ?>
</body>
</html>