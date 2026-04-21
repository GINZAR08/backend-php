<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>New Year Greetings</title>
</head>

<body>
    <?php
    $year = date('Y');
    echo "<h1>Happy $year!</h1>";
    ?>

    <br>

   <?php
    $date = new DateTimeImmutable('');
    date_default_timezone_set('UTC');
    print('logged in at ');
    ?>
    <span id="clock-server" data-ts="<?php echo $date->getTimestamp(); ?>">
      <?php echo $date->format('Y-m-d H:i:s'); ?>
    </span>
<?php
 $servername = "localhost";
$username = " jja43";
$password = "ExcaliburMorgan";
$dbname = "jja43_commentart";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>
   <br>

   <h1>Submit your response</h1>
   <form method="post" action="">
       <div class="submit">
           <input type="text" name="response" placeholder="Type your response here">
           <button type="submit">Submit</button>
                  </div>
             <?php
              if (isset($_POST["response"])) {
                echo "<p> your response has been received at " . $date->format('Y-m-d H:i:s') . "</p>";
              }
?>
    </form>

</body>
<script src="script.js"></script>
<link rel="stylesheet" href="first.css">
</html>
