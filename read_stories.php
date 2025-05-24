<?php
// DB connection
$host = "localhost";
$dbname = "dbjona";
$username = "your_username";
$password = "your_password";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, story, submitted_at FROM experiences ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Real Stories</title>
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      background: #f4f4f9;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background: linear-gradient(to right, #4b2e83, #5e4a9f);
      padding: 15px 30px;
      color: white;
      font-size: 1.4em;
      font-weight: bold;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .container {
      max-width: 900px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .story {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .story h3 {
      margin: 0 0 10px;
      color: #4b2e83;
    }

    .story p {
      font-size: 1.05em;
      color: #333;
      line-height: 1.5;
    }

    .date {
      font-size: 0.9em;
      color: #888;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <div class="navbar">Empathy Simulator – Real Stories</div>
  <div class="container">
    <h2>Stories Shared by Real People</h2>

    <?php
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $name = htmlspecialchars($row["name"]);
        $story = nl2br(htmlspecialchars($row["story"]));
        $date = date("F j, Y, g:i a", strtotime($row["submitted_at"]));

        echo "<div class='story'>";
        echo "<h3>" . ($name ? $name : "Anonymous") . "</h3>";
        echo "<p>$story</p>";
        echo "<div class='date'>Shared on $date</div>";
        echo "</div>";
      }
    } else {
      echo "<p>No stories yet. Be the first to share one!</p>";
    }

    $conn->close();
    ?>
  </div>
</body>
</html>
