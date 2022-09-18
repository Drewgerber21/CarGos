<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link ref="stylesheet" rel="indexstyles.css">
    <title>Buy Page</title>
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

<style>  
 
.resize {  
    width: 100px;
    height: auto;  
}  
</style>

<!-- Header Menu of the Page -->
<!-- <header>
        <nav>
            <ul>
            <div id="logo">
                <img class = resize src="CarGos Logo.png" />
            </div>

            <div id="Profile">
                <div> 
                <a href="buy_page.php">  
                    <button type="button" class="profile_button" >
                        <img class = button-container src="Profile.png"/>
                    </button> 
                </a>
                </div>
            </div>
                            
            </ul>
        </nav>  
</header> -->

<body>
    <a href="index.html">
        <button class="back-button">Go back</button>
    </a>
    <h1>Buy Page</h1>   
    <div class="buyMainDiv">
        <div class="buyButtonArray">
            <!-- Need to figure out how to check if someone is logged in and change button depending on that https://stackoverflow.com/questions/43714563/php-mysql-change-button-text-on-condition-->
            <a href="account_info.php">
                <button class="account-button login">Login</button>
                <div class="login-dropdown">
                    <!-- Could maybe create a hoverable login? https://www.w3schools.com/howto/howto_css_dropdown.asp -->
                </div>
            </a>
        </div>

        <!-- Mockup for grabbing listing data from db -->
        <div class="buyTempDiv">
            <?php
                $selectListing = "SELECT * FROM ListingInfo";
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
                    <td>" . $row["ListingPrice"] . "</a></td>" .
                    "<td><a href=\"listing_info.php?listingID=" . $row["ListingID"] . "&listingMake=" . $row["ListingMake"] . "&listingModel=" . $row["ListingModel"] . "\">" . $row["ListingMake"] . "</a></td>" .
                    "<td>" . $row["ListingModel"] . "</td" .
                    "<td>" . $row["ListingDesc"] . "</td>" .
                    "<td>" . $row["ListingDate"] . "</td>"
                    . "</tr>";
                }
                echo "</table>";
            ?>
        </div>
    </div>
    <?php
        $conn->close();
    ?>
</body>
</html>