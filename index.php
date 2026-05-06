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

  function handleGetRequest()
  {
    $oid = isset($_GET['oid']) ? $_GET['oid'] : null;
    
    if (!$oid) {
      http_response_code(400);
      echo json_encode(["error" => "oid parameter required"]);
      return;
    }

    $sql = "SELECT firstname, lastname, comment FROM people WHERE oid = ?";
    mysqli_report(MYSQLI_REPORT_STRICT);
    
    try {
      $stmt = $this->database->prepare($sql);
      if (!$stmt) {
        throw new Exception("Prepare failed: " . $this->database->error);
      }
      
      $stmt->bind_param("i", $oid);
      $stmt->execute();
      $resultSet = $stmt->get_result();
      
      if (!$resultSet) {
        throw new Exception("Error: " . $stmt->error);
      } else {
        $rows = [];
        while ($row = $resultSet->fetch_assoc()) {
          $rows[] = $row;
        }
        http_response_code(200);
        echo json_encode($rows);
      }
      $stmt->close();
      
    } catch (Exception $e) {
      http_response_code(500);
      echo "Error: " . $e->getMessage();
    }
  }


  function handlePostRequest()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["comment"])) {

        $firstName = trim($_POST['firstname']);
        $lastName = trim($_POST['lastname']);
        $comment = trim($_POST['comment']);

        $sql = "INSERT INTO people (firstname, lastname, comment) VALUES (?, ?, ?)";

        $stmt = $this->database->prepare($sql);
        if (!$stmt) {
          http_response_code(500);
          echo json_encode(["error" => "Prepare failed: " . $this->database->error]);
          return;
        }
        
        $stmt->bind_param("sss", $firstName, $lastName, $comment);
        $result = $stmt->execute();

        if ($result === false) {
          http_response_code(500);
          echo json_encode(["error" => "Error: " . $stmt->error]);
        } else {
          http_response_code(201);
          echo json_encode(["success" => "Record inserted successfully"]);
        }
        $stmt->close();


      } else {
        http_response_code(400);
        echo json_encode(["error" => "Missing required fields: firstname, lastname, comment"]);
      }
     }
    }


$db = new Dbconnection();
$db->handleRequestType();
}
?>