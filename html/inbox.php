<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
    <link rel="stylesheet" href="indexstyles.css">

    <?php
    $servername = "localhost";
    $user = "root";
    $password = "piWJbQv5Ksd8Yk";
    $dbname = "CarGos";

    $conn = mysqli_connect($servername, $user, $password, $dbname);

    if (!$conn) {
        die("Connection failed " . mysqli_connect_error());
    }
    ?>
</head>
<body class="pageBody">
    <?php 
    include("nav_bar.php"); 
    $inboxFromMessages = $conn->query("SELECT DISTINCT UserTO, UserFROM, ChatID, UserName FROM Inbox, UserInfo WHERE Inbox.UserFROM=" . $_SESSION["userID"] . " AND Inbox.UserTO = UserInfo.UserID");
    $inboxToMessages = $conn->query("SELECT DISTINCT UserTO, UserFROM, ChatID, UserName FROM Inbox, UserInfo WHERE Inbox.UserTO=" . $_SESSION["userID"] . " AND Inbox.UserFROM = UserInfo.UserID");
    ?>
    <div id="test">
    <?php
    if(mysqli_num_rows($inboxFromMessages) > 0) {
        while($row = mysqli_fetch_assoc($inboxFromMessages)) {
            echo "<a href=\"javascript:getMessages(" . $row["UserTO"] . ", " . $row["UserFROM"] . ", " . $row["ChatID"] . ")\">" . $row["UserName"] . " - " . $row["ChatID"] . "</a><br>";
        }
    }
    if (mysqli_num_rows($inboxToMessages) > 0) {
        while($row = mysqli_fetch_assoc($inboxToMessages)) {
            echo "<a href=\"javascript:getMessages(" . $row["UserTO"] . ", " . $row["UserFROM"] . ", " . $row["ChatID"] . ")\">" . $row["UserName"] . " - " . $row["ChatID"] . "</a><br>";
        }
    }
    $conn->close()
    ?>
    </div>
</body>
<script>
    function getMessages(userTo, userFrom, chatID) {
        fetch("receive_message.php?userTo=" + userTo + "&userFrom="  + userFrom + "&chatID=" + chatID)
        .then(response => response.json())
        .then(data => {})
        .catch(err => console.log(err));
    }
</script>
</html>