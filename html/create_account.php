<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
    <link rel="stylesheet" href="indexstyles.css">
</head>
<body>
    <input name="back" onclick="history.back()" type="submit" value="Go back">

    <?php
        $servername = "localhost";
        $user = "root";
        $password = "piWJbQv5Ksd8Yk";
        $dbname = "CarGos";

        $conn = mysqli_connect($servername, $user, $password, $dbname);
    
        if(!$conn) {
            die("Connection failed " . mysqli_connect_error());
        }
    ?>

    <h1>Create a <i>CarGos</i> account</h1>
    <div class="mainAccountDiv">
        <form action="create_account.php" method="post">
            <label for="accountLabel username">Username:</label>
            <input type="text" placeholder="Username" name="userName" id ="userName" required> <!-- Check if username is taken by querying account_info -->
            <label for="accountLabel password">Password:</label>
            <input type="password" placeholder="Password" name="userPass" id="userPass" required>
            <label for="accountLabel email">Email:</label>
            <input type="text" placeholder="Email" name="userEmail" id="userEmail" required>
            <label for="accountLabel phone">Phone number (optional):</label>
            <input type="text" placeholder="Phone number" name="phoneNum" id="phoneNum">
            <input type="submit" value="Create account"> <!-- Once submitted redirect back to buy_page -->
            <?php
                $userID = NULL;
                $userName = $_POST["userName"];
                $userPass = $_POST["userPass"];
                $userEmail = $_POST["userEmail"];
                $phoneNum = $_POST["phoneNum"];
                $userRole = 0;

                $insertUser = $conn->prepare("INSERT INTO UserInfo VALUES(?, ?, ?, ?, ?, ?);");
                $insertUser->bind_param("issssi", $userID, $userName, $userPass, $userEmail, $phoneNum, $userRole);
                $insertUser->execute();

                $_SESSION["username"] = $userName;
                if($_SERVER['REQUEST_METHOD'] == "POST") {
                    echo "<script type='text/javascript'>setTimeout(\"window.history.go(-2)\", 1000);</script>";
                }
            ?>
        </form>
    </div>
</body>
</html>