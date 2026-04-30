<?php

class Dbconnection
{
  private $database;
  private $statusCode = 0;
  private $result = array();

  private $rows;
  
  public function __construct()
  {

    $servername = "localhost";
    $username = "jja43_comment";
    $password = "ExcalMorgan";
    $dbname = "jja43_art";

    try {

      $this->database = new mysqli($servername, $username, $password, $dbname);

      if ($this->database->connect_error) {
        throw new Exception("Connection failed: " . $this->database->connect_error);
      }
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
      exit();
    }

  }

  function __destruct()
  {
    $this->database->close();
  }

  function handleRequestType()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->handlePostRequest();
    }else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $this->handleGetRequest();
    } else {
      http_response_code(405);
    }


  }


  function handlePostRequest()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["comment"])) {

        $firstName = trim($_POST['firstname']);
        $lastName = trim($_POST['lastname']);
        $comment = trim($_POST['comment']);



        $sql = " INSERT INTO people (firstname, lastname, comment) VALUES (? ,?, ?) ";

        $stmt = $this->database->prepare($sql);
        if (!$stmt) {
          throw new Exception("Prepare failed: " . $this->database->error);
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

    }

  }

  function handleGetRequest()
  {


    $sql = "SELECT firstname, lastname, comment FROM people WHERE oid = (?)";
    mysqli_report( MYSQLI_REPORT_STRICT);
    try{
     $this->database->prepare($sql);
    $result = $this->database->query($sql);

    if ($result === false) {
    throw new Exception("". $this->database->error);
    } else {
      while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
      }
      $result->free();

    }

   }
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

  </form>

  <?php if (empty($rows)): ?>
    <li>No comments yet</li>
  <?php else: ?>
    <?php foreach ($rows as $c): ?>
      <li>
        <?php echo htmlspecialchars($c['firstname']); ?>
        <?php echo htmlspecialchars($c['lastname']); ?>:
        <?php echo htmlspecialchars($c['comment']); ?>
      </li>
    <?php endforeach; ?>
  <?php endif; ?>
  </ul>
  </div>

</body>
<script src="script.js"></script>
<link rel="stylesheet" type="text/css" href="first.css">

</html>