<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        echo "<title>" . $_GET["listingMake"] . " " . $_GET["listingModel"] . " for sale!</title>";
    ?>
</head>
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
<body>
    <a href="buy_page.php">
        <button class="back-button">Go back</button>
    </a>
    <div>
        <?php
            $listingID = $_GET["listingID"];
            $selectListing = "SELECT * FROM ListingInfo WHERE ListingID = " . $listingID . ";";
            $result = mysqli_query($conn, $selectListing);
            if(mysqli_num_rows($result) > 0) {
                echo "<table class=\"listingTable\">
                <tr><th>Listing Price</th>
                <th>Listing Make</th>
                <th>Listing Model</th>
                <th>Listing Description</th>
                <th>Listing Date</th>";
            }

            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                <td>" . $row["ListingPrice"] . "</td>" .
                "<td>" . $row["ListingMake"] . "</td>" .
                "<td>" . $row["ListingModel"] . "</td" .
                "<td>" . $row["ListingDesc"] . "</td>" .
                "<td>" . $row["ListingDate"] . "</td>"
                . "</tr>";
            }
            echo "</table>";
        ?>
    </div>
    <?php
        $conn->close();
    ?>
</body>
</html>