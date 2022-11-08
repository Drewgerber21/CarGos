<?php

if(isset($_POST["chatID"]) && isset($_POST["userTo"])) {
    $servername = "localhost";
    $user = "root";
    $password = "piWJbQv5Ksd8Yk";
    $dbname = "CarGos";

    $conn = mysqli_connect($servername, $user, $password, $dbname);

    if (!$conn) {
        die("Connection failed " . mysqli_connect_error());
    }
    
    
    $chatID = $_POST["chatID"];
    $userTo = $_POST["userTo"];
    $userFrom = $_POST["userFrom"];
    $dateSent = $_POST["dateSent"];
    $messageContent = $_POST["messageContent"];
    $seen = 0;

    $messageID = mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(MessageID) FROM Inbox WHERE ChatID = " . $chatID . ";"));
    if(count($messageID) > 0) {
        $messageID[0] += 1;
    } else {
        $messageID[0] = 1;
    }

    $sendMessage = $conn->prepare("INSERT INTO Inbox(ChatID, MessageID, UserFROM, UserTO, DateSent, MessageContent, Seen) VALUES(?, ?, ?, ?, ?, ?, ?);");
    $sendMessage->bind_param("iiiissi", $chatID, $messageID[0], $userFrom, $userTo, $dateSent, $messageContent, $seen);
    $sendMessage->execute();

    $success = array(
        "ChatID" => $chatID,
        "MessageID" => $messageID[0],
        "UserFrom" => $userFrom,
        "UserTo" => $userTo,
        "DateSent" => $dateSent,
        "Message" => $messageContent,
        "Seen" => $seen,
    );

    $json = json_encode($success);
    echo $json;
} else {
    $error = array(
        "Error" => "Failed to send",
    );

    $json = json_encode($error);
    echo $json;
}
$conn->close();

?>