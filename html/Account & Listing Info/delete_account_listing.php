<?php

if(isset($_POST["listingID"])) {
    $servername = "localhost";
    $user = "root";
    $password = "piWJbQv5Ksd8Yk";
    $dbname = "CarGos";

    $listingID = $_POST["listingID"];

    $conn = mysqli_connect($servername, $user, $password, $dbname);

    
    if (!$conn) {
        die("Connection failed " . mysqli_connect_error());
    }

    $deleteListing = $conn->prepare("DELETE FROM ListingInfo WHERE ListingID=" . $listingID . ";");
    $deleteListing->execute();
    $imgUrl = "Listing_Photos/" . $listingID . ".png";
    unlink($imgUrl);

    $success = array(
        "Success" => "Listing deleted",
    );

    $json = json_encode($success);
    echo $json;
} else {
    $error = array(
        "Error" => "Failed to delete listing",
    );

    $json = json_encode($error);
    echo $json;
}

$conn->close();
?>