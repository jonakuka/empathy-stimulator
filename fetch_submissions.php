<?php
header('Content-Type: application/json');
include 'config.php';

$pdo = getPDO();

$stmt = $pdo->query("SELECT title, category, description, imageUrl FROM empathy_art_submissions ORDER BY created_at DESC LIMIT 50");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>