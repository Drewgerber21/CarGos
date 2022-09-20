<?php
    session_start();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account</title>
</head>
<body>
    <input name="back" onclick="history.back()" type="submit" value="Go back">
    <?php
        $username = $_GET["username"];
        echo $username . "'s page";
    ?>
</body>
</html>