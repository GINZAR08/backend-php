<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["comment"])) {

    $firstName = trim($_POST['firstname']);
    $lastName = trim($_POST['lastname']);
    $comment = trim($_POST['comment']);

    $servername = "localhost";
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



    $sql = " INSERT INTO people (firstname, lastname, comment) VALUES (? ,?, ?) ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
      die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("sss", $firstName, $lastName, $comment);
    $result = $stmt->execute();


    if ($result === false) {
      throw new Exception("Error: " . $stmt->error);
    }
    $stmt->close();
    try {
      if ($result === false) {
        throw new Exception("Error:cant get results " . $stmt->error);
      }
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }


  } else {
    http_response_code(400);
  }
} else {
  http_response_code(405);
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

  <form method="post" action="index.php">
    <label for="firstname">First Name:</label><br>
    <input type="text" id="firstname" name="firstname" required><br>
    <label for="lastname">Last Name:</label><br>
    <input type="text" id="lastname" name="lastname" required><br>
    <label for="comment">Comment:</label><br>
    <textarea id="comment" name="comment" required></textarea><br>
    <input type="submit" value="Submit">


</body>
<script src="script.js"></script>
<link rel="stylesheet" type="text/css" href="first.css">

</html>