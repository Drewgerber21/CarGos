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
  <link rel="icon" type="image/x-icon" href="/Favicon/favicon.ico">
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

    <div class="homeMainPage">
      <div class="homMainPageTitle">
        <h1>This is a title for stuff about our project</h1>
      </div>
      <div class="homeMainPageBody">
        <p>This is a bunch of text explaining stuff about our project</p>
      </div>
    </div>

    <div class="homeMainPageFooter">
      <p class="homeMainPageFooterText">People who worked on this project:</p>
      <p class="homeMainPageFooterText">Eddie</p>
      <p class="homeMainPageFooterText">Jose</p>
      <p class="homeMainPageFooterText">Drew</p>
    </div>
  </body>
</html>