<?php session_start(); ?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Listings</title>
        <link rel="stylesheet" href="../indexstyles.css">
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

    <body class="pageBody">
        <?php include("../nav_bar.php"); ?>
    </body>

    <div class="column-wrapper">
        <?php
            $userID = $_GET["userID"];
            $selectListing = "SELECT * FROM ListingInfo WHERE UserID = " . $userID . " ORDER BY ListingID DESC;";
            $result = mysqli_query($conn, $selectListing);
            while ($row = mysqli_fetch_assoc($result)) {
                $imgUrl = "Listing_Photos/" . $row["ListingID"] . ".png";
                echo "
                    <div class=\"column\"> 
                        <div class=\"columnImageDiv\">
                            <img src=\"/" . $imgUrl . "\" alt=\"Car Listing Image\" onerror=\"this.onerror=null; this.src='/Listing_Photos/defaultCarImageSquare.jpg'\" style=\"object-fit:contain; width:400px; height:400px;\">
                        </div>
                        <div class=\"columnTextDiv\">
                            <a class=\"columnText\" href=\"listing_info.php?listingID=" . $row["ListingID"] . "&listingMake=" . $row["ListingMake"] . "&listingModel=" . $row["ListingModel"] . "\"> " . $row["ListingYear"] . " " . $row["ListingMake"] . " " .  $row["ListingModel"] . " </a>
                            <p class=\"columnText\">$"  . $row["ListingPrice"] . " </p>'";
                            echo "<button id=\"" . $row["ListingID"] . "\" onclick=\"deleteListing(this);\">Delete</button>";
                            echo "<button type='button' onclick='location.href=\"listing_info.php?listingID=" . $row["ListingID"] . "&editingMode=true\"'>Edit</button>
                      </div>
                    </div>";
            }
            echo "</table>";
        ?>
        <?php $conn->close(); ?>
        <script>
            function deleteListing(divID) {
                var id = divID.id;
                fetch("delete_account_listing.php", {
                    method: "post",
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: "listingID=" + id,
                })
                .then(window.location.reload())
                .catch(err => console.log(err))
            }
        </script>   
    </div>
    <?php include("../footer.php"); ?>
</html>