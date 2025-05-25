<?php
include_once 'config.php'; // DB connection

// Handle new advice submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['advice'])) {
    $advice = $conn->real_escape_string($_POST["advice"]);
    if (!empty($advice)) {
        $conn->query("INSERT INTO advice_wall (advice, created_at) VALUES ('$advice', NOW())");
    }
}

// Handle new comment submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['comment']) && isset($_POST['advice_id'])) {
    $comment = $conn->real_escape_string($_POST["comment"]);
    $advice_id = (int)$_POST["advice_id"];
    if (!empty($comment) && $advice_id > 0) {
        $conn->query("INSERT INTO comments (advice_id, comment, created_at) VALUES ($advice_id, '$comment', NOW())");
    }
}

// Fetch all advice with IDs
$adviceResult = $conn->query("SELECT id, advice, created_at FROM advice_wall ORDER BY created_at DESC");

// Fetch all comments grouped by advice_id
$commentsResult = $conn->query("SELECT advice_id, comment, created_at FROM comments ORDER BY created_at ASC");

// Group comments by advice_id for easy lookup
$commentsByAdvice = [];
while ($commentRow = $commentsResult->fetch_assoc()) {
    $commentsByAdvice[$commentRow['advice_id']][] = $commentRow;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Anonymous Advice Wall with Comments</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    /* Reset and base */
    body {
      font-family: 'Inter', sans-serif;
      background: #f4f4f9;
      margin: 0;
      padding: 0;
      color: #333;
    }

    /* Navbar styles */
    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      background: linear-gradient(to right, #4b2e83, #5e4a9f);
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      z-index: 1000;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .logo {
      font-size: 1.8em;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 25px;
      margin: 0;
      padding: 0;
    }

    .nav-links a {
      color: #fefefe;
      text-decoration: none;
      font-size: 1em;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .nav-links a:hover {
      color: #ffcc70;
      text-decoration: underline;
    }

    main {
      margin-top: 80px; /* To avoid overlap with fixed navbar */
      padding: 20px;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    /* Container for advice + comments */
    .container {
      background: white;
      padding: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
    }
    * {
    box-sizing: border-box;
  }
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f5f7fa;
    margin: 0;
    padding: 0;
    color: #333;
  }
  header {
    background: linear-gradient(90deg, #4b2e83, #5e4a9f);
    padding: 2rem 1rem;
    color: white;
    text-align: center;
  }

    h2, h4 {
      color: #4b2e83;
      margin-top: 0;
    }

    /* Advice form */
    form textarea {
      width: 100%;
      height: 100px;
      padding: 0.75rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      resize: vertical;
      font-size: 1rem;
      margin-bottom: 1rem;
      font-family: inherit;
    }

    form input[type="hidden"] {
      display: none;
    }

    form button {
      padding: 0.6rem 1.2rem;
      background: #6c63ff;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
      font-family: inherit;
    }

    form button:hover {
      background: #5848e5;
    }

    /* Each advice box */
    .advice-box {
      background: #f8f8ff;
      border-left: 4px solid #6c63ff;
      padding: 1rem;
      margin-top: 1rem;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      color: #333;
    }

    .timestamp {
      font-size: 0.85rem;
      color: #888;
      margin-top: 0.5rem;
      text-align: right;
    }

    /* Comments section */
    .comments-section {
      margin-top: 1rem;
      padding-left: 1rem;
      border-left: 3px solid #6c63ff;
    }
    /* ...existing code... */
    /* Navbar styles */
.navbar {
  position: fixed;
  top: 0;
  width: 100%;
  background: linear-gradient(90deg, #5e4a9f, #4b2e83);
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  z-index: 1000;
  box-shadow: 0 6px 15px rgba(75, 46, 131, 0.5);
  backdrop-filter: saturate(180%) blur(8px);
  font-weight: 600;
  letter-spacing: 0.8px;
  font-size: 1rem;
  transition: background 0.3s ease;
}

.navbar:hover {
  background: linear-gradient(90deg, #6c63ff, #4b2e83);
  box-shadow: 0 8px 20px rgba(108, 99, 255, 0.6);
}

.logo {
  font-size: 2.2rem;
  font-weight: 900;
  background: linear-gradient(45deg, #ffcc70, #6c63ff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  cursor: default;
  user-select: none;
  letter-spacing: 2px;
  transition: transform 0.3s ease;
}

.logo:hover {
  transform: scale(1.1);
}

.nav-links {
  list-style: none;
  display: flex;
  gap: 30px;
  margin: 0;
  padding: 0;
}

.nav-links a {
  color: #fefefe;
  text-decoration: none;
  font-size: 1.1rem;
  font-weight: 600;
  position: relative;
  padding-bottom: 5px;
  transition: color 0.3s ease;
}

.nav-links a::after {
  content: "";
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 0;
  background: #ffcc70;
  transition: width 0.3s ease;
}

.nav-links a:hover {
  color: #ffcc70;
}

.nav-links a:hover::after {
  width: 100%;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(120deg, #f8fafc 0%, #e0c3fc 100%);
  background-attachment: fixed;
  color: #333;
  margin: 0;
  padding: 0;
  min-height: 100vh;
  position: relative;
}

body::before {
  content: "";
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: url('https://www.transparenttextures.com/patterns/diamond-upholstery.png');
  opacity: 0.08;
  z-index: 0;
  pointer-events: none;
}
/* ...existing code... */

    .comments-section h4 {
      margin-bottom: 0.5rem;
    }

    .comment {
      background: #eee;
      color: #222;
      padding: 8px 12px;
      border-radius: 6px;
      margin-bottom: 8px;
      font-size: 0.9rem;
      position: relative;
    }

    .comment .comment-time {
      font-size: 0.75rem;
      color: #666;
      margin-top: 4px;
      text-align: right;
    }

    /* Comment form */
    .comment-form textarea {
      height: 60px;
      margin-top: 8px;
    }

    @media (max-width: 480px) {
      main {
        padding: 15px 10px;
        margin-top: 90px;
      }
    }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="logo">Empathy Simulator</div>
  <ul class="nav-links">
    <li><a href="empathy_simulator.php">Empathy Simulator</a></li>
    <li><a href="empathy_quiz.php">Empathy Quiz or Test</a></li>
    <li><a href="anonymous_advice_wall.php">Anonymous Advice Wall</a></li>
    <li><a href="art_gallery.php">Empathy Art</a></li>
    
   
  </ul>
</nav>
  
  <main>
    <div class="container">
      <h2>Share Your Anonymous Advice 💬</h2>
      <form method="POST" action="">
        <textarea name="advice" placeholder="Write something helpful, kind, or thoughtful..." required></textarea>
        <button type="submit">Post Anonymously</button>
      </form>
    </div>

    <h2>Recent Advice</h2>

    <?php while($advice = $adviceResult->fetch_assoc()): ?>
      <div class="container advice-box">
        <?= nl2br(htmlspecialchars($advice['advice'])) ?>
        <div class="timestamp"><?= date("F j, Y, g:i a", strtotime($advice['created_at'])) ?></div>

        <!-- Comments section -->
        <div class="comments-section">
          <h4>Comments:</h4>
          <?php 
            if (!empty($commentsByAdvice[$advice['id']])) {
              foreach ($commentsByAdvice[$advice['id']] as $comment) {
                echo '<div class="comment">' . nl2br(htmlspecialchars($comment['comment'])) . '<div class="comment-time">' . date("M j, Y, g:i a", strtotime($comment['created_at'])) . '</div></div>';
              }
            } else {
              echo '<p style="color:#888; font-style: italic;">No comments yet.</p>';
            }
          ?>

          <!-- Comment form -->
          <form method="POST" action="" class="comment-form">
            <input type="hidden" name="advice_id" value="<?= $advice['id'] ?>" />
            <textarea name="comment" placeholder="Add a comment..." required></textarea>
            <button type="submit">Comment</button>
          </form>
        </div>
      </div>
    <?php endwhile; ?>
  </main>

</body>
</html>
