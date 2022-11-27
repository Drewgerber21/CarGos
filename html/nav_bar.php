<div class="pageHeader">
    <img src="/Website Logos/CarGos Logo.png" width="200" />
</div>

<div class="pageNav">
    <div class="navButtonDiv">
        <button class="navButton" onclick="location.href='../index.php'">Home</button>
    </div>
    <div class="navButtonDiv">
        <button class="navButton" onclick="location.href='../buy_page.php'">Buy</button>
    </div>
    <div class="navButtonDiv">
        <button class="navButton" onclick="location.href='../sell_page.php'">Sell</button>
    </div>

    <div class="navButtonDiv inbox">
        <button class="navButton" onclick="location.href='../Inbox/inbox.php'">Inbox</button>
    </div>
    <div class="navButtonDiv login">
        <!-- Need to figure out how to check if someone is logged in and change button depending on that https://stackoverflow.com/questions/43714563/php-mysql-change-button-text-on-condition-->
        <?php if (!isset($_SESSION["username"])) {  ?>
            <button class="navButton" onclick="loginPopup()">Login</button>
            <div id="login-popup">
                <!-- Use session_destroy() on log out -->
                <form action=<?php echo "\"" . $_SERVER['REQUEST_URI'] . "\"" ?> class="login-popup container" method="post">
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
                    if (mysqli_num_rows($result) > 0) {
                        $_SESSION["username"] = $username;
                        while($row = mysqli_fetch_assoc($result))
                            $_SESSION["userID"] = $row["UserID"];
                        echo "<meta http-equiv='refresh' content='0'>";
                    } else if (!isset($_SESSION["username"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
                        echo "<script type='text/javascript'>alert('Wrong username or password!');</script>";
                    }
                    ?>
                    <button type="button" class="login-popup-btn cancel" onclick="loginPopdown()">X</button>
                    <a class="createAccLink" href="../Account & Listing Info/create_account.php">Create an account!</a>
                </form>
            </div>
        <?php } else { //else show account info
            echo "<button class=\"navButton\" onclick='accountPopup()'>Welcome " . $_SESSION["username"] . "</button>";
        ?>
            <div id="account-popup">
                <div class="account-container">
                <?php
                echo "<button type='button' class='account-popup-btn settings' onclick='location.href=\"../Account & Listing Info/account_info.php?username=" . $_SESSION["username"] . "&userID=" . $_SESSION["userID"] . "\"'>Account Settings</button>";
                echo "<button type='button' class='account-popup-btn listings' onclick='location.href=\"../Account & Listing Info/account_listings.php?userID=" . $_SESSION["userID"] . "\"'>Your Listings</button>"; //user listings
                ?>
                <form method="post">
                    <input name="logoutcheck" type="hidden" value="logoutcheck">
                    <input name="logout" class="account-popup-btn logout" type="submit" value="Logout">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST["logoutcheck"])) {
                        unset($_SESSION["username"]);
                        session_destroy();
                        //if on account_info probably just redirect to index.php
                        if(strpos($_SERVER['REQUEST_URI'], "account_info.php") || strpos($_SERVER['REQUEST_URI'], "account_listings.php")) //checks to see if account_info is in the url string
                            header("Location: https://cargos.me/");
                        else
                            echo "<script type='text/javascript'>setTimeout(\"window.history.go(-1)\", 500);</script>";
                    }
                    ?>
                </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


<script>
    function accountPopup() {
        document.getElementById("account-popup").style.display = "block";
    }

    function accountPopdown() {
        document.getElementById("account-popup").style.display = "none";
    }

    document.addEventListener('mouseup', function(e) {
        var account_div = document.getElementById("account-popup");
        if(!account_div.contains(e.target)) {
            accountPopdown();
        }
    })

    function loginPopup() {
        document.getElementById("login-popup").style.display = "block";
    }

    function loginPopdown() {
        document.getElementById("login-popup").style.display = "none";
    }

    document.addEventListener('mouseup', function(e) {
        var popup_div = document.getElementById("login-popup");
        if (!popup_div.contains(e.target)) {
            loginPopdown();
        }
    })
</script>