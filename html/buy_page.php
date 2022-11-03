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
    <title>Buy Page</title>
    <link rel="icon" type="image/x-icon" href="/Website Logos/favicon.ico">
</head>

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

<body class="pageBody" style="box-sizing: border-box">
    <body>
        <?php include("nav_bar.php"); ?>
    </body>
    
    <div class="gridContainer">
        <div class="sideBar">
            <?php
                echo "
                <p>Filters</p>
                <form method='get' action=''>
                    <p>Price Range:</p>
                    <p>Min: <input type='number' name='minPrice' id='minPrice' min='0' max='99999999' step='1'> </p>
                    <p>Max: <input type='number' name='maxPrice' id='maxPrice' min='0' max='99999999' step='1'> </p>
                    <button type='submit'>Apply</button>
                </form> ";
            ?>
        </div>
        <div class="mainContentDiv">
            <!-- Displays listings in a grid -->
            <div class="column-wrapper">
                <?php
                    $selectListing = "SELECT * FROM ListingInfo ORDER BY ListingID DESC";
                    $result = mysqli_query($conn, $selectListing);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $imgUrl = "Listing_Photos/" . $row["ListingID"] . ".png";
                        echo "
                            <a href=\"listing_info.php?listingID=" . $row["ListingID"] . "&listingMake=" . $row["ListingMake"] . "&listingModel=" . $row["ListingModel"] . "\">
                                <div class=\"column\" > 
                                    <div class=\"columnImageDiv\">
                                        <img src=\"/" . $imgUrl . "\" alt=\"Car Listing Image\" onerror=\"this.onerror=null; this.src='/Listing_Photos/defaultCarImageSquare.jpg'\" style=\"object-fit:contain; width:400px; height:400px;\">

                                    </div>
                                    <div class=\"columnTextDiv\">
                                        <a class=\"columnText\" href=\"listing_info.php?listingID=" . $row["ListingID"] . "&listingMake=" . $row["ListingMake"] . "&listingModel=" . $row["ListingModel"] . "\"> " . $row["ListingYear"] . " " . $row["ListingMake"] . " " .  $row["ListingModel"] . " </a>
                                        <p class=\"columnText\">$"  . $row["ListingPrice"] . " </p>
                                    </div>
                                </div>
                            </a>";
                    }
                ?>      

                <?php
                    $conn->close();
                ?>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>