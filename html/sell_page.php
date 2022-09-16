<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Page</title>
</head>
<body>
    <a href="https://cargos.me">
        <button class="back-button">Go Back</button>
    </a>

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
<h1>Sell Page</h1>
    <div class="sellMainDiv">
        <form method="post" action="sell_page.php" class="sellPageForm">
        <!-- Creating a create listing mockup-->
        <div class="sellButtonArray">
            <label for="listingPrice" class="listingLabel price">Listing Price: $</label>
            <input type="number" name="listingPrice" id="listingPrice" min="1" max="99999999" step="1" placeholder="0" required><br>
            <label for="listingDesc" class="listingLabel desc">Listing Description: </label><br>
            <input type="text" name="listingDesc" id="listingDesc"><br>
            <input type="submit" value="Create Listing">
            <?php
                $listingID = null;
                $userID = 2;
                $listingPrice = $_POST["listingPrice"];
                $listingDesc = $_POST["listingDesc"];
                $listingDate = date("Y-m-d");

                $insertListing = $conn->prepare("INSERT INTO ListingInfo(ListingID, UserID, ListingPrice, ListingDesc, ListingDate) VALUES(?, ?, ?, ?, ?);");
                $insertListing->bind_param("iiiss", $listingID, $userID, $listingPrice, $listingDesc, $listingDate);
                $insertListing->execute();
            ?>
        </div>
        </form>
    </div>
    <?php
        $conn->close();
    ?>
</body>
</html>