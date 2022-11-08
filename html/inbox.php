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
<script>
    function linkLabels(userTo, userFrom, chatID) {
        let label = document.getElementById(chatID);
        label.href = "javascript:getMessages(" + userTo + ", " + userFrom + ", " + chatID + ")";
    }
</script>
<body class="pageBody">
    <?php 
    include("nav_bar.php"); 
    $inboxLabel = $conn->query("SELECT DISTINCT ChatID, UserName FROM Inbox, UserInfo WHERE (Inbox.UserFROM=" . $_SESSION["userID"] . " AND Inbox.UserTO = UserInfo.UserID) OR (Inbox.UserTO=" . $_SESSION["userID"] . " AND Inbox.UserFROM = UserInfo.UserID)");
    $inboxMessages = $conn->query("SELECT DISTINCT UserTO, UserFROM, ChatID, UserName FROM Inbox, UserInfo WHERE (Inbox.UserFROM=" . $_SESSION["userID"] . " AND Inbox.UserTO = UserInfo.UserID) OR (Inbox.UserTO=" . $_SESSION["userID"] . " AND Inbox.UserFROM = UserInfo.UserID)");

    ?>
    <div id="test">
    <?php
    if(mysqli_num_rows($inboxLabel) > 0) {
        while($row = mysqli_fetch_assoc($inboxLabel)) {
            $listingName = mysqli_fetch_array(mysqli_query($conn, "SELECT ListingYear, ListingMake, ListingModel FROM ListingInfo WHERE ListingID = '" . $row["ChatID"] . "';"));
            $listingComb = $listingName["ListingYear"] . " " . $listingName["ListingMake"] . " " . $listingName["ListingModel"];
            echo "<a id=\"" . $row["ChatID"] . "\">" . $row["UserName"] . " - " . $listingComb . "</a><br>";
        }
        while($row = mysqli_fetch_assoc($inboxMessages)) {
            echo "<script> linkLabels(" . $row["UserTO"] . ", " . $row["UserFROM"] . ", " . $row["ChatID"] . "); </script>";
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
        .then(data => {
            let mainDiv = document.getElementById("test");
            clearMessages(mainDiv);

            let div = document.createElement("div");
            div.id = "chatDiv";

            for(let i = 0; i < data.length; ++i) {
                div.innerHTML += data[i].UserFrom + " - " + data[i].MessageContent + "<br>";
            }

            mainDiv.appendChild(div);

            let message = document.createElement("input");
            message.type = "text";
            message.id = "messageBack";
            div.appendChild(message);

            let sendButton = document.createElement("button");
            sendButton.id = "sendButton";
            sendButton.innerHTML = "Send Message";
            sendButton.addEventListener("click", function() { 
                if(userTo == <?php echo $_SESSION["userID"] ?>) {
                    sendMessage(chatID, userFrom, userTo, <?php echo "\"" . date("Y-m-d h:i:s") . "\"" ?>)
                    location.reload();
                } else {
                    sendMessage(chatID, userTo, userFrom, <?php echo "\"" . date("Y-m-d h:i:s") . "\"" ?>)
                    location.reload();
                }
            });
            div.appendChild(sendButton);
        })
        .catch(err => console.log(err));
    }

    function sendMessage(chatID, userTo, userFrom, sendDate) {
        var messageContent = document.getElementById("messageBack").value;
        fetch("send_message.php", {
            method: "post",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: "chatID=" + chatID + "&userTo=" + userTo + "&userFrom=" + userFrom + "&dateSent=" + sendDate + "&messageContent=" + messageContent,
        })
        .catch(err => console.log(err));
    }


    function clearMessages(div) {
        if(div.hasChildNodes) {
            div.removeChild(div.lastChild);
        }
    }
</script>
</html>