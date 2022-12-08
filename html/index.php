<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CarGos Main Page</title>
  <link rel="stylesheet" href="indexstyles.css">
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
    <?php include("nav_bar.php"); ?>

    <div class="mainContentDiv">
      <div class="homMainPageTitle">
        <h1>CarGos - Where your car will go(somewhere else)</h1>
      </div>
      <div class="homeMainPageBody">
        <p>This project was inspired by online marketplaces such as Facebook Marketplace and Offerup in order to create a better, car-oriented solution.</p>
      </div>
    </div>

    <?php include("footer.php"); ?>
    </div>
  </body>
</html>