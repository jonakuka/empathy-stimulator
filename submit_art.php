<?php
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
error_log(print_r($_POST, true));  // Log form data to check if it's being sent correctly

// Database connection
include 'config.php'; // Make sure this file contains a valid connection to your database

// Get and sanitize input
$title = trim($_POST['title'] ?? '');
$category = trim($_POST['category'] ?? '');
$description = trim($_POST['description'] ?? '');
$imageUrl = trim($_POST['imageUrl'] ?? '');

// Validate required fields
if (!$title || !$category || !$description) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields.']);
    exit;
}

// Prepare and execute statement
$stmt = $conn->prepare("INSERT INTO empathy_art_submissions (title, category, description, imageUrl) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $title, $category, $description, $imageUrl);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
