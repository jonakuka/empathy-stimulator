<?php
header('Content-Type: application/json');
include 'config.php';

$pdo = getPDO();

$title = trim($_POST['title'] ?? '');
$category = $_POST['category'] ?? '';
$description = trim($_POST['description'] ?? '');
$imageUrl = trim($_POST['imageUrl'] ?? '');

$allowed_categories = ['photo', 'painting', 'quote'];

if (!$title || !$description || !in_array($category, $allowed_categories)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

if ($imageUrl && !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid image URL']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO empathy_art_submissions (title, category, description, imageUrl) VALUES (?, ?, ?, ?)");
try {
    $stmt->execute([$title, $category, $description, $imageUrl ?: null]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save submission']);
}
?>