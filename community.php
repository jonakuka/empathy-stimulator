<?php
session_start();
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("
    SELECT f.feeling, f.timestamp, u.username 
    FROM feedback f 
    JOIN users u ON f.user_id = u.id 
    ORDER BY f.timestamp DESC
");
?>

<h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>
<a href="logout.php">Logout</a>
<h2>Community Feedback Wall</h2>

<?php while ($row = $result->fetch_assoc()): ?>
  <div class="feedback-card">
    <strong><?= htmlspecialchars($row['username']) ?></strong> felt:
    <em><?= htmlspecialchars($row['feeling']) ?></em><br>
    <small><?= $row['timestamp'] ?></small>
  </div>
<?php endwhile; ?>
