


<?php
    $date = new DateTimeImmutable('');
    date_default_timezone_set('UTC');
    print('logged in at ');
    ?>

    <span id="clock-server" data-ts="<?php echo $date->getTimestamp(); ?>">
      <?php echo $date->format('Y-m-d H:i:s'); ?>
    </span>

    <?php

    $servername = "brighton.domains";
    $username = "jja43_comment";
    $password = "ExcalMorgan";
    $dbname = "jja43_art";

    $conn = new mysqli($servername, $username, $password, $dbname);
   try {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
   } catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
   }

 if ($_SERVER["REQUEST_METHOD"] == "POST") {


   $firstName = $_POST["firstname"];
   $lastName = $_POST["lastname"];
   $ID = $_POST["ID"];
   $comment = $_POST["comment"];
 }
   ?>

<?php
  $sql = "INSERT INTO people (ID, firstname, lastname, comment) VALUES (?,? , ?, ?)";

  $stmt = $conn->prepare($sql);
   if (!$stmt) { die('Prepare failed: '.$conn->error); }
   $stmt->bind_param("isss", $ID, $firstName, $lastName, $comment);
    $result = $stmt->execute();
    if ($result === false) {
        throw new Exception("Error: " . $stmt->error);
    }
   //$stmt = $conn->prepare($sql);
 // $stmt->bind_param("isss", $ID, $firstName, $lastName, $comment);
 // $result = $stmt->execute();
 try {
    if ($result === false){
        throw new Exception("Error:cant get results " . $stmt->error);
    }
 } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Index of examples</title>
</head>

<body>
    <h1>Comments</h1>


</body>
<script src="script.js"></script>
<link rel="stylesheet" type="text/css" href="first.css">
</html>
