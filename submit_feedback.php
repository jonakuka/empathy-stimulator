<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in (assuming user ID stored in session)
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please log in to submit feedback.'
    ]);
    exit;
}

// Validate input (basic)
$feeling = $_POST['feeling'] ?? '';
$comments = $_POST['comments'] ?? '';

if (empty($feeling)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please select how you felt after the simulation.'
    ]);
    exit;
}

// Optionally sanitize inputs (for example purposes)
$feeling = filter_var($feeling, FILTER_SANITIZE_STRING);
$comments = filter_var($comments, FILTER_SANITIZE_STRING);

// TODO: Connect to your database and store feedback
// Example: Use PDO or MySQLi to insert feedback into your feedback table
// For demo, we'll skip DB storage.

// Return success response
echo json_encode([
    'success' => true,
    'message' => 'Thank you for your feedback!'
]);
?>