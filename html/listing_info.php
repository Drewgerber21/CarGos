<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexstyles.css">
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
<body class="pageBody" style="box-sizing: border-box">
    <?php include("nav_bar.php"); ?>

    <div>
        <?php
            $listingID = $_GET["listingID"];
            $editingMode = $_GET["editingMode"];
            $selectListing = "SELECT * FROM ListingInfo WHERE ListingID = " . $listingID . ";";
            $result = mysqli_query($conn, $selectListing);
            while ($row = mysqli_fetch_assoc($result)) {
                if(!$_GET["editingMode"]) {
                echo "
                    <div>
                        <h1> " . $row["ListingYear"] . " " . $row["ListingMake"] . " " .  $row["ListingModel"] . " </h1>
                        <h2>Price: $"  . $row["ListingPrice"] . " </h2>
                        <img src=\"/Listing_Photos/defaultCarImageSquare.jpg\" alt=\"Default Image\" style=\"width:400px;height:400px;\">
                        <p> " . $row["ListingDesc"] . " </p>
                        <p>Posted " . $row["ListingDate"] . " </p>
                    </div>
                ";
                } else {
                ?>
                    <form method="post">
                    <?php
                    echo "
                    <div>
                        <h1> " . $row["ListingYear"] . " " . $row["ListingMake"] . " " . $row["ListingModel"] . " </h1>
                        <label for='listingPrice' class='listingLabel price'>Listing Price: $</label>
                        <input type='number' name='listingPrice' id='listingPrice' min='1' max='99999999' step='1' value='" . $row["ListingPrice"] . "' required><br>
                        <img src=\"/Listing_Photos/defaultCarImageSquare.jpg\" alt=\"Default Image\" style=\"width:400px;height:400px;\"><br>
                        <textarea name='listingDesc' id='listingDesc'>" . $row["ListingDesc"] . "</textarea>
                    </div>";
                    ?>
                    <input type="submit" name="update" value="Update">
                    <?php
                        $listingPrice = $_POST["listingPrice"];
                        $listingDesc = $_POST["listingDesc"];

                        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["update"])) {
                            $updateListing = $conn->prepare("UPDATE ListingInfo SET ListingDesc=?, ListingPrice=? WHERE ListingID=" . $listingID . ";");
                            $updateListing->bind_param("si", $listingDesc, $listingPrice);
                            $updateListing->execute();
                            echo "<meta http-equiv='refresh' content='0'>";
                        }
                    ?>
                    </form>
                    
                    <?php
                }
            }
        ?>
    </div>
    <?php
        $conn->close();
    ?>
    <div class="homeMainPageFooter">
      <p class="homeMainPageFooterText">People who worked on this project:</p>
      <p class="homeMainPageFooterText">Eddie</p>
      <p class="homeMainPageFooterText">Jose</p>
      <p class="homeMainPageFooterText">Drew</p>
    </div>
</body>
</html>