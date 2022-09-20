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
<body>
    <a href="index.html">
        <button class="back-button">Go back</button>
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
        <div class="accountButtonDiv">
            <div class="accountButtonArray">
            <!-- Need to figure out how to check if someone is logged in and change button depending on that https://stackoverflow.com/questions/43714563/php-mysql-change-button-text-on-condition-->
            <?php //https://www.w3schools.com/php/php_sessions.asp
            if(!isset($_SESSION["username"])) {//Checks to see if there's a variable in the session assigned to username
                echo '<button class="login-button login" onclick="loginPopup()">Login</button>'; //if not then show login button
            } else { //else show account info
                echo "Welcome&nbsp;<a href='account_info.php?username=" . $_SESSION["username"] . "'</a> " . $_SESSION["username"] . "!";
            }
            ?>
            <div id="login-popup"> <!-- Use session_destroy() on log out -->
                <form action="sell_page.php" class="login-popup container" method="post">
                    <h1><i>CarGos</i> Login</h1>

                    <label for="usernames"><b>Username</b></label>
                    <input type="text" placeholder="Username" name="user" id="user" required>

                    <label for="pass"><b>Password</b></label>
                    <input type="password" placeholder="Password" name="pass" id="pass" required>

                    <button type="submit" class="login-popup-btn login">Login</button>
                    <?php 
                        $username = $_POST["user"];
                        $password = $_POST["pass"];

                        $findUser = "SELECT * FROM UserInfo WHERE UserName = '" . $username . "' AND UserPass ='" . $password . "';";
                        $result = mysqli_query($conn, $findUser);
                        if(mysqli_num_rows($result) > 0) {
                            $_SESSION["username"] = $username;
                            echo "<meta http-equiv='refresh' content='0'>";
                        } else if (!isset($_SESSION["username"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
                            echo "<script type='text/javascript'>alert('Wrong username or password!');</script>";
                        }
                    ?>
                    <button type="button" class="login-popup-btn cancel" onclick="loginPopdown()">X</button>
                    <a class="createAccLink" href="create_account.php">Create an account!</a>
                </form>
            </div>
            </div>
            <!-- Create some sort of pop up when login button is clicked? https://www.w3schools.com/howto/howto_js_popup_form.asp-->
        </div>
        <form method="post" action="sell_page.php" class="sellPageForm">
        <!-- Creating a create listing mockup-->
            <div class="sellInputs" id="sellInputs">
                <label for="listingPrice" class="listingLabel price">Listing Price: $</label>
                <input type="number" name="listingPrice" id="listingPrice" min="1" max="99999999" step="1" placeholder="0" required><br>
                <label for="listingYear" class="listingLabel year">Listing Year: </label>
                <input type="number" name="listingYear" id="listingYear" min="1900" max="2023" step="1" placeholder="2022" required><br>
                <label for="listingMake" class="listingLabel make">Listing Make: </label>
                <input type="text" name="listingMake" id="listingMade"><br>
                <label for="listingModel" class="listingLabel model">Listing Model: </label>
                <input type="text" name="listingModel" id="listingModel"><br>
                <label for="listingDesc" class="listingLabel desc">Listing Description: </label><br>
                <input type="text" name="listingDesc" id="listingDesc"><br>
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
        if(isset($_SESSION["username"])) {
            echo "<script type='text/javascript'>document.getElementById('sellInputs').style.visibility='visible';</script>";
        }
    ?>
    <script>
        function loginPopup() {
            document.getElementById("login-popup").style.display = "block";
        }

        function loginPopdown() {
            document.getElementById("login-popup").style.display = "none";
        }

        document.addEventListener('mouseup', function(e) {
            var popup_div = document.getElementById("login-popup");
            if(!popup_div.contains(e.target)) {
                loginPopdown();
            }
        })
    </script>
    <?php
        $conn->close();
    ?>
</body>
</html>