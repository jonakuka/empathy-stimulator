<?php
include_once 'config.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

$score = 0;
$totalQuestions = 0;
$feedback = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
    $answers = $_POST['answers'];
    $totalQuestions = count($answers);
    $score = 0;

    foreach ($answers as $question_id => $option_id) {
        $question_id = (int)$question_id;
        $option_id = (int)$option_id;

        $res = $conn->query("SELECT score FROM empathy_quiz_options WHERE id = $option_id AND question_id = $question_id LIMIT 1");
        if ($res && $row = $res->fetch_assoc()) {
            $score += (int)$row['score'];
        }
    }

    $maxScore = $totalQuestions * 5; // max per question = 5
    $percent = ($score / $maxScore) * 100;

    if ($percent >= 80) {
        $feedback = "Excellent empathy skills! You really understand others.";
    } elseif ($percent >= 50) {
        $feedback = "Good job! There's room to grow your empathy.";
    } else {
        $feedback = "Keep practicing empathy — it’s a skill that can be developed!";
    }
}

// Fetch questions and options
$questions = [];
$qRes = $conn->query("SELECT * FROM empathy_quiz_questions ORDER BY id ASC");
if (!$qRes) {
    die("Error fetching questions: " . $conn->error);
}
while ($qRow = $qRes->fetch_assoc()) {
    $qId = $qRow['id'];
    $questions[$qId] = [
        'question' => $qRow['question'],
        'options' => []
    ];

    $oRes = $conn->query("SELECT * FROM empathy_quiz_options WHERE question_id = $qId ORDER BY id ASC");
    if (!$oRes) {
        die("Error fetching options: " . $conn->error);
    }
    while ($oRow = $oRes->fetch_assoc()) {
        $questions[$qId]['options'][] = $oRow;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Empathy Quiz or Test</title>
<style>
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
  header h1 {
    margin: 0;
    font-size: 2.5rem;
    letter-spacing: 2px;
  }
  header p {
    margin-top: 0.5rem;
    font-size: 1.2rem;
    font-weight: 300;
  }
  main {
    max-width: 720px;
    margin: 2rem auto 4rem auto;
    padding: 1rem 2rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(75,46,131,0.15);
  }
  header {
  margin-top: 90px;
}
  /* New intro section */
  .intro {
    background-color: #e9e6fd;
    border-left: 6px solid #4b2e83;
    padding: 20px;
    margin-bottom: 2rem;
    border-radius: 8px;
  }
  .intro h2 {
    color: #4b2e83;
    margin-top: 0;
  }
  .intro p {
    font-size: 1.05rem;
    line-height: 1.5;
    color: #333;
  }
  form {
    margin-top: 1.5rem;
  }
  .question {
    margin-bottom: 24px;
  }
  .question p {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 12px;
    color: #4b2e83;
  }
  label {
    display: block;
    margin-bottom: 10px;
    cursor: pointer;
    font-size: 1rem;
  }
  input[type="radio"] {
    margin-right: 10px;
    accent-color: #6c63ff;
    cursor: pointer;
  }
  button {
    display: block;
    background-color: #6c63ff;
    color: white;
    border: none;
    padding: 14px 28px;
    font-size: 1.15rem;
    border-radius: 8px;
    cursor: pointer;
    margin: 2rem auto 0 auto;
    transition: background-color 0.3s ease;
  }
  button:hover {
    background-color: #5848e5;
  }
  .result {
    background-color: #e8f0fe;
    border-left: 6px solid #4b2e83;
    padding: 20px;
    border-radius: 8px;
    margin-top: 2rem;
    font-size: 1.15rem;
    color: #2f2f2f;
  }
  .result strong {
    color: #4b2e83;
  }
  footer {
    text-align: center;
    padding: 1rem;
    color: #666;
    font-size: 0.9rem;
  }
  @media (max-width: 480px) {
    main {
      margin: 1rem 1rem 3rem 1rem;
      padding: 1rem 1rem;
    }
    header h1 {
      font-size: 2rem;
    }
  }
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

<header>
  <h1>Empathy Quiz or Test</h1>
  <p>Test your empathy skills and discover how well you connect with others’ feelings.</p>
</header>

<main>

  <!-- Intro: What is Empathy Test -->
  <section class="intro">
    <h2>What is an Empathy Test?</h2>
    <p>
      An empathy test measures your ability to understand and share the feelings of others. 
      It helps you become more aware of how you relate to people’s emotions in everyday life. 
      Developing empathy can improve your relationships, communication, and emotional intelligence.
    </p>
    <p>
      This quiz is designed to give you insight into your empathy level through realistic scenarios 
      and common social situations. Take your time and answer honestly to get the most accurate result.
    </p>
  </section>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
  <div class="result">
    <p><strong>Your Score: <?= $score ?> / <?= $totalQuestions * 5 ?></strong></p>
    <p><?= htmlspecialchars($feedback) ?></p>
    <p><a href="<?= $_SERVER['PHP_SELF'] ?>" style="color:#6c63ff; text-decoration:none;">Try Again</a></p>
  </div>
<?php else: ?>
  <form method="POST" action="">
    <?php foreach ($questions as $qId => $qData): ?>
      <div class="question">
        <p><?= htmlspecialchars($qData['question']) ?></p>
        <?php foreach ($qData['options'] as $option): ?>
          <label>
            <input type="radio" name="answers[<?= $qId ?>]" value="<?= $option['id'] ?>" required />
            <?= htmlspecialchars($option['option_text']) ?>
          </label>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>

    <button type="submit">Submit Quiz</button>
  </form>
<?php endif; ?>

</main>

<footer>
  &copy; <?= date('Y') ?> Empathy Simulator — Built with ❤️
</footer>

</body>
</html>

