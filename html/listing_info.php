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
            $selectListing = "SELECT * FROM ListingInfo WHERE ListingID = " . $listingID . ";";
            $result = mysqli_query($conn, $selectListing);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                    <div>
                        <h1> " . $row["ListingYear"] . " " . $row["ListingMake"] . " " .  $row["ListingModel"] . " </h1>
                        <h2>Price: $"  . $row["ListingPrice"] . " </h2>
                        <img src=\"defaultCarImageSquare.jpg\" alt=\"Default Image\" style=\"width:400px;height:400px;\">
                        <p> " . $row["ListingDesc"] . " </p>
                        <p>Posted " . $row["ListingDate"] . " </p>
                    </div>
                ";
            }
            echo "</table>";
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