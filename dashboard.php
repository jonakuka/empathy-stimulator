<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';  // Your database connection here

$userId = $_SESSION['user_id'];

// Get user info
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

// Fetch feedbacks from other users
$feedbacks = [];
$sql = "SELECT f.id, f.user_id, f.feeling, u.username 
        FROM feedback f 
        JOIN users u ON f.user_id = u.id 
        WHERE f.user_id != ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $feedbacks[] = $row;
}
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard - Empathy Simulator</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f4f6f8;
      margin: 0;
      padding: 0;
      color: #333;
    }
    header, nav {
      background-color: #3b82f6;
      padding: 15px 30px;
      color: white;
      font-weight: 600;
      font-size: 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    nav a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-weight: 600;
    }
    nav a:hover {
      text-decoration: underline;
    }
    .container {
      max-width: 1000px;
      margin: 30px auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    h1 {
      margin-bottom: 10px;
      font-weight: 700;
      color: #111827;
    }
    .user-info {
      margin-bottom: 40px;
      font-size: 1.1rem;
      color: #4b5563;
    }
    .feedback-list {
      list-style: none;
      padding: 0;
    }
    .feedback-list li {
      background: #e0f2fe;
      padding: 15px 20px;
      margin-bottom: 15px;
      border-radius: 6px;
      box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
    }
    .feedback-list li strong {
      color: #1e40af;
    }
    .logout-btn {
      background: #ef4444;
      border: none;
      color: white;
      padding: 8px 14px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: 600;
    }
    .logout-btn:hover {
      background: #dc2626;
    }
  </style>
</head>
<body>
  <nav>
    <div>Empathy Simulator</div>
    <div>
      <a href="empathy_simulator.html">Simulator</a>
      <a href="statistics.php">Statistics</a>
      <a href="logout.php">Logout</a>
    </div>
  </nav>

  <div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    <p class="user-info">Email: <?php echo htmlspecialchars($email); ?></p>

    <h2>Feedback from other users</h2>
    <?php if (count($feedbacks) > 0): ?>
      <ul class="feedback-list">
        <?php foreach ($feedbacks as $fb): ?>
          <li>
            <strong><?php echo htmlspecialchars($fb['username']); ?></strong> felt: <em><?php echo htmlspecialchars($fb['feeling']); ?></em><br />
            <?php echo nl2br(htmlspecialchars($fb['comment'])); ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No feedback from others yet. Be the first to share your feelings!</p>
    <?php endif; ?>
  </div>

</body>
</html>
