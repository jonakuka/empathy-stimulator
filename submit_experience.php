<?php
$host = "localhost";      // or your DB host
$dbname = "dbjona";
$username = "your_username";
$password = "your_password";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
$story = isset($_POST['story']) ? $conn->real_escape_string($_POST['story']) : '';

if (trim($story) === '') {
  echo "Story cannot be empty.";
  exit;
}

$sql = "INSERT INTO experiences (name, story) VALUES ('$name', '$story')";

if ($conn->query($sql) === TRUE) {
  echo "success";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
?>
