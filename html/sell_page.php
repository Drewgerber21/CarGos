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
    <link rel="icon" type="image/x-icon" href="/Favicon/favicon.ico">
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

    <div class="mainContentDiv">
        <form method="post" action="sell_page.php" class="sellPageForm" enctype="multipart/form-data">
            <!-- Creating a create listing mockup-->
            <div class="sellInputs" id="sellInputs">
                <label for="listingPrice" class="listingLabel price">Listing Price: $</label>
                <input type="number" name="listingPrice" id="listingPrice" min="1" max="99999999" step="1" placeholder="0" required><br>
                <label for="listingYear" class="listingLabel year">Listing Year: </label>
                <input type="number" name="listingYear" id="listingYear" min="1900" max="2023" step="1" placeholder="2022" required><br>
                <label for="listingMake" class="listingLabel make">Listing Make: </label>
                <select name="listingMake" id="listingMake"> 
                    <script>
                        var selectMake = document.getElementById("listingMake");
                        fetch("https://vpic.nhtsa.dot.gov/api/vehicles/GetMakesForVehicleType/car?format=json")
                        .then(result => result.json())
                        .then(data => {
                            for(let i = 0; i < data.Results.length; i++) {
                                var option = document.createElement("option");
                                option.value = data.Results[i].MakeName;
                                option.text = data.Results[i].MakeName;
                                selectMake.appendChild(option);
                            }
                        })
                        .catch(err => {console.log(err)});
                    </script>
                </select>
                <br><br>
                <!--
                <input type="text" name="listingMake" id="listingMade"><br>
                -->
                <!-- Probably want to grab value of year and make then populate an optgroup with some parsed json from an api call using fetch -->
                <!-- https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch -->

                <label for="listingModel" class="listingLabel model">Listing Model: </label>
                <select name="listingModel" id="listingModel">
                    <script>
                        document.getElementById("listingMake").onchange = findModels
                        function findModels() {
                            document.getElementById("listingModel").innerHTML = "";
                            console.log(document.getElementById("listingMake").value + " test " + document.getElementById("listingYear").value);
                            var selectModel = document.getElementById("listingModel");
                            fetch('https://vpic.nhtsa.dot.gov/api/vehicles/getmodelsformakeyear/make/' + document.getElementById("listingMake").value + '/modelyear/' + document.getElementById("listingYear").value +'?format=json')
                            .then(response => response.json())
                            .then(data => {
                                for(let i = 0; i < data.Results.length; i++) {
                                    var model = document.createElement("option");
                                    model.value = data.Results[i].Model_Name;
                                    model.text = data.Results[i].Model_Name;
                                    selectModel.appendChild(model);
                                }
                            })
                            .catch(err => { console.log(err) });
                        }
                    </script>
                <!-- ADD MORE MAKES AND MODELS
                     ADD A WAY TO CHECK IF THE MODEL'S OPTGROUP LABEL MATCHES THE listingMake
                -->
                </select>
                <br><br>
                <!--
                <input type="text" name="listingModel" id="listingModel"><br>
                -->
                <label for="listingPhoto" class="listingLabel photo">Listing Photo: </label><br>
                <input type="file" name="file" accept="image/*"><br><br>
                <label for="listingDesc" class="listingLabel desc">Listing Description: </label><br>
                <textarea name="listingDesc" id="listingDesc"></textarea><br>
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

                    if($_SERVER["REQUEST_METHOD"] == "POST") {
                        $listingQuery = mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(ListingID) FROM ListingInfo WHERE UserID = " . $userID . ";"));
                        $listingIDtest = $listingQuery[0];
                        $fileName = $listingIDtest;
                        if(!imagepng(imagecreatefromstring(file_get_contents($_FILES["file"]["tmp_name"])),__DIR__ . "/Listing_Photos/" . $fileName . ".png")) {
                            echo $_FILES["file"]["error"];//"<script> console.log(\"it didn't work\"); </script>";
                        } 
                    }
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
    <?php include("footer.php"); ?>
</body>

</html>