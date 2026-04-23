


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
    $username = " jja43_comment";
    $password = "ExcaliburMorgan";
    $dbname = "jja43_art";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Index of examples</title>
</head>

<body>
    <h1>Comments</h1>

    <form action="submit_comment.php" method="post">
        <label for="comment">Comment:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50"></textarea><br>
        <input type="submit" value="Submit">
        <?php
              if (isset($_POST["response"])) {
                echo "<p> your response has been received at " . $date->format('Y-m-d') . "</p>";
              }
?>
    </form>

    

</body>
<script src="script.js"></script>
<link rel="stylesheet" type="text/css" href="first.css">
</html>
