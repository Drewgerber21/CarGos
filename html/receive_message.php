<?php
session_start();


if($_GET["userTo"] && $_GET["userFrom"] && $_GET["userFrom"] == $_SESSION["userID"] && $_GET["chatID"]) {
    $servername = "localhost";
    $user = "root";
    $password = "piWJbQv5Ksd8Yk";
    $dbname = "CarGos";

    $conn = mysqli_connect($servername, $user, $password, $dbname);

    if (!$conn) {
        die("Connection failed " . mysqli_connect_error());
    }
    
    $selectMessages = "SELECT * FROM Inbox WHERE UserFROM=" . $_GET["userFrom"] . " AND UserTO=" . $_GET["userTo"] . " AND ChatID=" . $_GET["chatID"] . ";";
    $messageQuery = mysqli_query($conn, $selectMessages);

    $messages = [];
    while($row = mysqli_fetch_assoc($messageQuery)) {
        $messages[] = array(
            "ChatID" => $row["ChatID"],
            "MessageID" => $row["MessageID"],
            "UserFrom" => $row["UserFROM"],
            "UserTo" => $row["UserTO"],
            "DateSent" => $row["DateSent"],
            "MessageContent" => $row["MessageContent"],
            "Seen" => $row["Seen"]
        );
    }

    $json = json_encode($messages);
    echo $json;
} else {
    $error = array(
        "Error" => "Failed to retrieve",
    );

    $json = json_encode($error);
    echo $json;
}
$conn->close();
?>  
