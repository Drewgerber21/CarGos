<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexstyles.css">
    <title>Test Buy Page</title>
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

<body class="pageBody" style="box-sizing: border-box">
    <body>
        <?php include("nav_bar.php"); ?>
    </body>
    
    <div class="column-wrapper">
		<div class="column">1</div>
		<div class="column">2</div>
		<div class="column">3</div>
        <div class="column">4</div>
        <div class="column">5</div>
		<div class="column">6</div>
		<div class="column">7</div>
        <div class="column">8</div>
        <div class="column">9</div>
	</div>

</body>
</html>