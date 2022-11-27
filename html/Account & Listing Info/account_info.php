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
    <title>Your Account</title>
    <link rel="icon" type="image/x-icon" href="/Website Logos/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
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
</head>
<body  id="pageBody">
    <body>
        <?php include("../nav_bar.php"); ?>
    </body>

    <?php
    $username = $_GET["username"];
    $userID = $_GET["userID"];
    if(isset($_SESSION["username"]) && $_SESSION["username"] == $username && $_SESSION["userID"] == $userID) {
        //All the fun account info stuff goes here
    ?>

            <?php
                $selectListing = "SELECT * FROM UserInfo WHERE UserID = " . $userID . ";";
                $result = mysqli_query($conn, $selectListing);
                $row = $result -> fetch_array(MYSQLI_ASSOC);
                //printf ("%s\n", $row["UserEmail"]);

            ?>



            <div class="flex items-start gap-4 p-4 min-h-screen">
                <img class="w-100 h-100 rounded-full \" src="/Website Logos/Profile.png">
                    <div class="flex flex-col">
                        <strong class="mt-20 text-slate-900 font-medium text-4xl dark:text-slate-200">
                        <?php
                        printf("User   : %s\n", $username);
                        ?>
                        </strong>
                        <span class="text-slate-500 font-medium text-3xl dark:text-slate-400">
                        <?php
                        printf("Email : %s\n", $row["UserEmail"]);
                        ?> </span>
                        <form method="POST">
                        <div id="passwordDiv" class="flex-row">
                            <input type="password" placeholder="Change Password" name="userPass" id="userPass" required class="px-1 border-black border-2 rounded-full">
                            <?php
                            echo '<input type="submit" class="py-1 px-2 bg-black rounded-md text-white text-sm shadow hover:opacity-75 cursor-pointer" id="changePassword" value="Update">';
                            ?>
                        </div>
                        </form>
                        <?php
                        if($_POST["userPass"]) {
                            $newPass = $_POST["userPass"];
                            $userID = $_SESSION["userID"];

                            $updatePassword = $conn->prepare("UPDATE UserInfo SET UserPass=? WHERE UserID=?;");
                            $updatePassword->bind_param("si", $newPass, $userID);
                            $updatePassword->execute();
                        }
                        ?>
                    </div>
            </div>
    <?php
    } else if(isset($_SESSION["username"]) && $_SESSION["username"] != $username && $_SESSION["userID"] != $userID) {
        echo "You do not have access to this page!";
    } else {
        echo "Please log in to view this page!";
    }
    ?>
    <?php include("../footer.php"); ?>
</body>
</html>