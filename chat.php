<?php
session_start();
include 'config.php';

$feeling = $_GET['feeling'] ?? '';
$name = $_GET['name'] ?? ($_SESSION['chat_name'] ?? '');

$feeling_labels = [
    'deeply_moved' => '😭 Deeply Moved',
    'gained_new_perspective' => '🧠 Gained New Perspective',
    'felt_sadness' => '😢 Felt Sadness',
    'felt_inspired' => '✨ Felt Inspired',
    'somewhat_empathized' => '🙂 Somewhat Empathized',
    'confused_or_overwhelmed' => '😵 Confused/Overwhelmed',
    'did_not_relate' => '😐 Did Not Relate'
];
if (!isset($feeling_labels[$feeling])) die("Invalid feeling.");

// If name not set, ask for it
if (!$name) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['chat_name'])) {
        $_SESSION['chat_name'] = trim($_POST['chat_name']);
        header("Location: chat.php?feeling=" . urlencode($feeling) . "&name=" . urlencode($_SESSION['chat_name']));
        exit();
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <title>Enter Name for Chat</title>
      <link rel="stylesheet" href="style.css" />
      <style>
        .name-form { max-width: 350px; margin: 5em auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 16px rgba(108,99,255,0.08); padding: 2em; text-align:center;}
        .name-form input { width: 80%; padding: 0.7em; border-radius: 7px; border: 1px solid #bcdffb; margin-bottom: 1em;}
        .name-form button { background: linear-gradient(90deg, #4a90e2, #6c63ff); color: #fff; border: none; border-radius: 7px; padding: 0.6em 2em; font-weight: 600; cursor: pointer;}
      </style>
    </head>
    <body>
      <div class="name-form">
        <h2>Enter Your Name to Join the Chat</h2>
        <form method="post">
          <input type="text" name="chat_name" placeholder="Your Name" required maxlength="30" />
          <br>
          <button type="submit">Join Chat</button>
        </form>
      </div>
    </body>
    </html>
    <?php
    exit();
}

// Handle new message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $msg = trim($_POST['message']);
    if ($msg !== '') {
        $stmt = $conn->prepare("INSERT INTO chat_messages (user_name, feeling, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $feeling, $msg);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: chat.php?feeling=" . urlencode($feeling) . "&name=" . urlencode($name));
    exit();
}

// Fetch messages
$stmt = $conn->prepare("SELECT * FROM chat_messages WHERE feeling = ? ORDER BY created_at ASC");
$stmt->bind_param("s", $feeling);
$stmt->execute();
$messages = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Chat - <?= htmlspecialchars($feeling_labels[$feeling]) ?></title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .chat-room { max-width: 600px; margin: 2em auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 16px rgba(108,99,255,0.08); padding: 2em; }
    .chat-header { font-size: 1.3em; color: #4a47a3; margin-bottom: 1em; text-align: center; }
    .chat-messages { max-height: 350px; overflow-y: auto; margin-bottom: 1.5em; }
    .chat-msg { margin-bottom: 1em; }
    .chat-msg .user { font-weight: 600; color: #4b2e83; }
    .chat-msg .time { color: #888; font-size: 0.9em; margin-left: 8px; }
    .chat-form textarea { width: 100%; border-radius: 7px; border: 1px solid #bcdffb; padding: 0.7em; min-height: 60px; }
    .chat-form button { margin-top: 0.5em; background: linear-gradient(90deg, #4a90e2, #6c63ff); color: #fff; border: none; border-radius: 7px; padding: 0.6em 2em; font-weight: 600; cursor: pointer; }
    .chat-form button:hover { background: linear-gradient(90deg, #6c63ff, #4a90e2); }
  </style>
</head>
<body>
  <nav class="navbar" id="main-navbar">
    <div class="logo">Empathy Simulator</div>
    <ul class="nav-links">
      <li><a href="empathy_simulator.php">Empathy Simulator</a></li>
      <li><a href="statistics.php">Statistics</a></li>
      <li><a href="anonymous_advice_wall.php">Advice Wall</a></li>
    </ul>
  </nav>
  <main>
    <div class="chat-room">
      <div class="chat-header">
        Chat Room for: <?= $feeling_labels[$feeling] ?>
        <div style="font-size:0.9em;color:#888;margin-top:0.3em;">You are chatting as <strong><?= htmlspecialchars($name) ?></strong></div>
      </div>
      <div class="chat-messages">
        <?php while ($msg = $messages->fetch_assoc()): ?>
          <div class="chat-msg">
            <span class="user"><?= htmlspecialchars($msg['user_name']) ?></span>
            <span class="time"><?= htmlspecialchars($msg['created_at']) ?></span><br>
            <?= nl2br(htmlspecialchars($msg['message'])) ?>
          </div>
        <?php endwhile; ?>
      </div>
      <form class="chat-form" method="post" action="?feeling=<?= urlencode($feeling) ?>&name=<?= urlencode($name) ?>">
        <textarea name="message" required placeholder="Type your message..."></textarea>
        <button type="submit">Send</button>
      </form>
    </div>
  </main>
</body>
</html>