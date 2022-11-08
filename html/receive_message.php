<?php
session_start();


if($_GET["userTo"] && $_GET["userFrom"] && ($_GET["userFrom"] == $_SESSION["userID"] ||  $_GET["userTo"] == $_SESSION["userID"]) && $_GET["chatID"]) {
    $servername = "localhost";
    $user = "root";
    $password = "piWJbQv5Ksd8Yk";
    $dbname = "CarGos";

    $conn = mysqli_connect($servername, $user, $password, $dbname);

    
    if (!$conn) {
        die("Connection failed " . mysqli_connect_error());
    }
    
    $selectMessages = "SELECT * FROM Inbox WHERE (UserFROM=" . $_GET["userFrom"] . " OR UserTO=" . $_GET["userFrom"] . ") AND ChatID=" . $_GET["chatID"] . ";";
    $messageQuery = mysqli_query($conn, $selectMessages);

    $messages = [];
    while($row = mysqli_fetch_assoc($messageQuery)) {
        $userFromQuery = mysqli_fetch_array(mysqli_query($conn, "SELECT UserName FROM UserInfo WHERE UserID = '" . $row["UserFROM"] . "';"));
        $userToQuery = mysqli_fetch_array(mysqli_query($conn, "SELECT UserName FROM UserInfo WHERE UserID = '" . $row["UserTO"] . "';"));
        $listingName = mysqli_fetch_array(mysqli_query($conn, "SELECT ListingYear, ListingMake, ListingModel FROM ListingInfo WHERE ListingID = '" . $row["ChatID"] . "';"));
        $listingComb = $listingName["ListingYear"] . " " . $listingName["ListingMake"] . " " . $listingName["ListingModel"];
        $messages[] = array(
            "ChatID" => $listingComb,
            "MessageID" => $row["MessageID"],
            "UserFrom" => $userFromQuery[0],
            "UserTo" => $userToQuery[0],
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
