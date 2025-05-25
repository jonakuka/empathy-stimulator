<?php
$servername = "localhost"; // or the IP address of your DB server
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "dbjona"; // Your database name

// Create connection
$conn = new mysqli('localhost', 'root', '', 'dbjona');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
