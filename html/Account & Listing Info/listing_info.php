<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../indexstyles.css">
    <?php echo "<title>" . $_GET["listingMake"] . " " . $_GET["listingModel"] . " for sale!</title>"; ?>
    <link rel="icon" type="image/x-icon" href="/Website Logos/favicon.ico">
     <script src="https://cdn.tailwindcss.com"></script>
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
<body id="pageBody" style="box-sizing: border-box">
    <?php include("../nav_bar.php"); ?>
    <div>
        <?php
            $listingID = $_GET["listingID"];
            $editingMode = $_GET["editingMode"];
            $selectListing = "SELECT * FROM ListingInfo WHERE ListingID = " . $listingID . ";";
            $result = mysqli_query($conn, $selectListing);

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <script>
                    window.onload = function() {
                        getMessages(<?php echo $row["UserID"] ?>, <?php echo $_SESSION["userID"] ?>, <?php echo $row["ListingID"] ?>);
                    }
                </script>
                <?php
                $imgUrl = "Listing_Photos/" . $row["ListingID"] . ".png";
                if(!$_GET["editingMode"]) {
                echo "
                    <div id=\"container\" class=\"flex flex-row flex-wrap\">
                        <div id=\"img\" class=\"mr-10 ml-auto\">
                            <img class=\"rounded-md my-10\" src=\"/" . $imgUrl . "\" alt=\"Default Image\" onerror=\"this.onerror=null; this.src='/Listing_Photos/defaultCarImageSquare.jpg'\" style=\"width:600px;height:500px;\">
                        </div>
                        <div id=\"listinginfo\" class=\"mr-auto ml-10 m-5\">
                            <h1 class=\"text-xl font-bold\"> " . $row["ListingYear"] . " " . $row["ListingMake"] . " " .  $row["ListingModel"] . " </h1>
                            <h2>$"  . $row["ListingPrice"] . " </h2>
                            <p class=\"overflow-hidden overflow-y-auto max-w-sm max-h-96 my-2\"> " . $row["ListingDesc"] . " </p>";
                            if($row["UserID"] != $_SESSION["userID"]) {
                            ?>
                                <input type="text" name="messageContent" id="messageContent" class="py-1 px-1.5 shadow-sm border-black border-2 rounded-sm focus:ring focus:ring-black">
                            <?php
                                echo "<button class=\"py-2 px-3 bg-black rounded-md text-white text-sm shadow hover:opacity-75\" id='messageBtn' onclick='sendMessage(" . $row["ListingID"] . ", " . $row["UserID"] . ", " . $_SESSION["userID"] . ", \"" . date("Y-m-d h:i:s") . "\")'>Send Message</button>";
                            }
                            echo "<p>Posted " . $row["ListingDate"] . " </p>
                        </div>
                    </div>
                ";
                } else {
                ?>
                    <form method="post">
                    <?php
                    echo "
                    <div id=\"container\" class=\"flex flex-row flex-wrap\">
                    <div id=\"img\" class=\"mr-10 ml-auto\">
                        <img class=\"rounded-md my-10\" src=\"/" . $imgUrl . "\" alt=\"Default Image\" onerror=\"this.onerror=null; this.src='/Listing_Photos/defaultCarImageSquare.jpg'\" style=\"width:600px;height:500px;\">
                    </div>
                    <div id=\"listinginfo\" class=\"mr-auto ml-10 m-5 relative\">
                        <h1 class=\"text-xl font-bold\"> " . $row["ListingYear"] . " " . $row["ListingMake"] . " " . $row["ListingModel"] . " </h1>
                        <label for='listingPrice' class='listingLabel price'>$</label>
                        <input class=\"border-black border-2 rounded-md\" type='number' name='listingPrice' id='listingPrice' min='1' max='99999999' step='1' value='" . $row["ListingPrice"] . "' required><br>
                        <textarea class=\"max-h-96 py-1 px-1.5 shadow-sm border-black border-2 rounded-sm\" name='listingDesc' id='listingDesc'>" . $row["ListingDesc"] . "</textarea>
                        <br><input class=\"mx-14 py-2 px-3 bg-black rounded-md text-white text-sm shadow hover:opacity-75\" type=\"submit\" name=\"update\" value=\"Update\">
                    </div>
                    </div>";
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
    <?php include("../footer.php"); ?>
</body>
<script>
    function goToChats() {
        window.location.href = "../Inbox/inbox.php";
    }

    function sendMessage(chatID, userTo, userFrom, sendDate) {
        var messageContent = document.getElementById("messageContent").value;
        fetch("../Inbox/send_message.php", {
            method: "post",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: "chatID=" + chatID + "&userTo=" + userTo + "&userFrom=" + userFrom + "&dateSent=" + sendDate + "&messageContent=" + messageContent,
        })
        .then(() => {
            document.getElementById("messageContent").style.display = "none";
            document.getElementById("messageBtn").innerHTML = "Check Message";
            document.getElementById("messageBtn").onclick = goToChats;
        })
        .catch(err => console.log(err));
    }

    function getMessages(userTo, userFrom, chatID) {
        fetch("../Inbox/receive_message.php?userTo=" + userTo + "&userFrom="  + userFrom + "&chatID=" + chatID)
        .then(response => response.json())
        .then(data => {
            if(data.length > 0) {
                document.getElementById("messageContent").style.display = "none";
                document.getElementById("messageBtn").innerHTML = "Check Message";
                document.getElementById("messageBtn").onclick = goToChats;
            }
        })
        .catch(err => console.log(err));
    }

</script>
</html>