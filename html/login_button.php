<div class="accountButtonDiv">
    <div class="accountButtonArray">
        <!-- Need to figure out how to check if someone is logged in and change button depending on that https://stackoverflow.com/questions/43714563/php-mysql-change-button-text-on-condition-->
        <?php //https://www.w3schools.com/php/php_sessions.asp
        if (!isset($_SESSION["username"])) { //Checks to see if there's a variable in the session assigned to username
            echo '<button class="login-button login" onclick="loginPopup()">Login</button>'; //if not then show login button
        } else { //else show account info
            echo "Welcome&nbsp;<a href='account_info.php?username=" . $_SESSION["username"] . "'</a> " . $_SESSION["username"] . "!";
        }
        ?>
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

<script>
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