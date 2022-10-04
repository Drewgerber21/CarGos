<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Page</title>
    <link rel="stylesheet" href="indexstyles.css">
</head>

<body  class="pageBody">
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
    <body>
        <?php include("nav_bar.php"); ?>
    </body>

    <div class="sellMainDiv">
        <form method="post" action="sell_page.php" class="sellPageForm">
            <!-- Creating a create listing mockup-->
            <div class="sellInputs" id="sellInputs">
                <label for="listingPrice" class="listingLabel price">Listing Price: $</label>
                <input type="number" name="listingPrice" id="listingPrice" min="1" max="99999999" step="1" placeholder="0" required><br>
                <label for="listingYear" class="listingLabel year">Listing Year: </label>
                <input type="number" name="listingYear" id="listingYear" min="1900" max="2023" step="1" placeholder="2022" required><br>
                <label for="listingMake" class="listingLabel make">Listing Make: </label>
                <select name="listingMake" id="listingMake"> <!-- why listingMade?? and not listingMake?? - Jose-->
                    <option value="Toyota">Toyota</option>
                    <option value="Ford">Ford</option>
                    <option value="Volkswagen">Volkswagen</option>
                    <option value="Audi">Audi</option>
                    <option value="Chevy">Chevy</option>
                    <option value="Honda">Honda</option>
                    <option value="Hyundai">Hyundai</option>
                </select>
                <br><br>
                <!--
                <input type="text" name="listingMake" id="listingMade"><br>
                -->
                <!-- Probably want to grab value of year and make then populate an optgroup with some parsed json from an api call using fetch -->
                <!-- https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch -->
                <label for="listingModel" class="listingLabel model">Listing Model: </label>
                <select name="listingModel" id="listingModel">
                    <optgroup label = "Toyota">
                        <option value="Camry">Camry</option>
                        <option value="Corolla">Corolla</option>
                        <option value="Tacoma">Tacoma</option>
                        <option value="Tundra">Tundra</option>
                        <option value="Prius">Prius</option>
                    <optgroup label = "Ford">
                        <option value="F150">F150</option>   
                    <optgroup label = "Volkswagen">    
                        <option value="Jetta">Jetta</option>
                <!-- ADD MORE MAKES AND MODELS
                     ADD A WAY TO CHECK IF THE MODEL'S OPTGROUP LABEL MATCHES THE listingMake
                -->
                </select>
                <br><br>
                <!--
                <input type="text" name="listingModel" id="listingModel"><br>
                -->
                <label for="listingDesc" class="listingLabel desc">Listing Description: </label><br>
                <textarea name="listingDesc" id="listingDesc"></textarea>
                <input type="submit" value="Create Listing">
            <?php
                $listingID = null;
                $uidQuery = mysqli_fetch_array(mysqli_query($conn, "SELECT UserID FROM UserInfo WHERE UserName = '" . $_SESSION["username"] . "';"));
                $userID = $uidQuery[0];
                $listingPrice = $_POST["listingPrice"];
                $listingDesc = $_POST["listingDesc"];
                $listingDate = date("Y-m-d");
                $listingMake = $_POST["listingMake"];
                $listingModel = $_POST["listingModel"];
                $listingYear = $_POST["listingYear"];

                $insertListing = $conn->prepare("INSERT INTO ListingInfo(ListingID, UserID, ListingPrice, ListingDesc, ListingDate, ListingMake, ListingModel, ListingYear) VALUES(?, ?, ?, ?, ?, ?, ?, ?);");
                $insertListing->bind_param("iiissssi", $listingID, $userID, $listingPrice, $listingDesc, $listingDate, $listingMake, $listingModel, $listingYear);
                $insertListing->execute();
            ?>
            </div>
        </form>
    </div>
    <?php
    if (isset($_SESSION["username"])) {
        echo "<script type='text/javascript'>document.getElementById('sellInputs').style.visibility='visible';</script>";
    } else {
        echo "<p>You are not logged in. Please log in to create a listing!</p>";
    }
    ?>
    <?php
    $conn->close();
    ?>
</body>

</html>