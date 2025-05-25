<?php
header('Content-Type: application/json');

include 'config.php';

$res = $conn->query("SELECT * FROM empathy_art_submissions ORDER BY id DESC");

$items = [];
while ($row = $res->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);
$conn->close();
?>