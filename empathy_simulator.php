<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Empathy Simulator - Walk in Their Shoes</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
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
  <section class="intro" style="background: linear-gradient(120deg, #f7faff 60%, #e9e4f0 100%); border-radius: 18px; box-shadow: 0 6px 24px rgba(76, 115, 255, 0.07); padding: 2.5em 2em 2em 2em; margin-bottom: 2.5em; margin-top: 100px; text-align: center;">
    <h1 style="font-size:2.7em; font-weight:900; color:#4b2e83; letter-spacing:1.5px; margin-bottom:0.2em;">
      <span style="vertical-align:middle;">💜</span> Welcome to the Empathy Simulator
    </h1>
    <h2 class="subtitle" style="font-weight:500; color:#4a90e2; margin-top:0; font-size:1.5em; letter-spacing:0.5px;">
      Step Into Someone Else’s World
    </h2>
    <blockquote style="font-style:italic; color:#555; border-left:4px solid #4a90e2; margin:1.5em auto 1em auto; padding-left:1.2em; max-width:600px; background:rgba(74,144,226,0.07); border-radius:8px;">
      “You never really understand a person until you consider things from his point of view... Until you climb inside of his skin and walk around in it.”<br>
      <span style="font-size:0.95em; color:#888;">— Harper Lee, <i>To Kill a Mockingbird</i></span>
    </blockquote>
    <p class="intro-text" style="margin-bottom:1.7em; font-size:1.18em; color:#444; max-width:700px; margin-left:auto; margin-right:auto;">
      <span style="font-size:1.5em; vertical-align:middle;">🌍</span>
      The Empathy Simulator invites you to experience life through the eyes of others. Choose a story and make choices as if you were living that reality.
      <br><br>
      <span style="font-weight:600; color:#4b2e83;">Why try this?</span>
    </p>
    <ul style="margin-bottom:1.7em; color:#333; line-height:1.8; font-size:1.13em; display:inline-block; text-align:left; background:rgba(108,99,255,0.05); border-radius:10px; padding:1em 2em;">
      <li>🤝 Build deeper understanding of diverse life experiences</li>
      <li>🧠 Challenge your assumptions and broaden your perspective</li>
      <li>💬 Practice compassion and emotional intelligence</li>
      <li>📝 Reflect on your feelings and share your insights</li>
    </ul>
    <p style="font-size:1.18em; color:#222; margin-top:1.2em;">
      <span style="font-size:1.3em; vertical-align:middle;">✨</span>
      <b>Ready to begin?</b> Select a story below and start your journey of empathy.
    </p>
  </section>

  <section class="simulation-selector">
    <label for="scenarioSelect">Choose a story to experience:</label>
    <select id="scenarioSelect">
      <option value="" disabled selected>Select a scenario</option>
      <option value="homeless">A Day as a Homeless Teen</option>
      <option value="blind">Navigating Life Without Sight</option>
      <option value="refugee">Fleeing Home as a Refugee</option>
      <option value="bullying">Living with School Bullying</option>
      <option value="wheelchair">Life in a Wheelchair</option>
      <option value="anxiety">Struggling with Anxiety in Public</option>
    </select>
    <button id="startBtn">Start Simulation</button>
  </section>

  <section id="simulator" style="display:none;">
    <div class="sim-img-wrap">
      <img id="stepImage" alt="Scene Image" />
    </div>
    <div class="sim-content">
      <p id="storyText"></p>
      <div id="options"></div>
    </div>
  </section>

  <!-- Feedback form shown after simulation ends -->
  <div id="endContainer" style="display:none; flex-direction: column; align-items: center;">
    <section class="feedback" id="feedbackSection" style="display:none; min-width:320px;">
      <h2>How did you feel after the simulation?</h2>
      <form id="feelingForm" autocomplete="off">
        <div class="form-group">
          <label for="name">Your Name:</label>
          <input type="text" id="name" name="name" required placeholder="Enter your name" />
        </div>
        <div class="form-group">
          <label for="feeling">How did you feel after the simulation?</label>
          <select name="feeling" id="feeling" required>
            <option value="" disabled selected>Select an option</option>
            <option value="deeply_moved">😭 I was deeply moved</option>
            <option value="gained_new_perspective">🧠 I gained a new perspective</option>
            <option value="felt_sadness">😢 I felt sadness</option>
            <option value="felt_inspired">✨ I felt inspired to take action</option>
            <option value="somewhat_empathized">🙂 I somewhat empathized</option>
            <option value="confused_or_overwhelmed">😵 I felt confused or overwhelmed</option>
            <option value="did_not_relate">😐 I did not relate</option>
          </select>
        </div>
        <div class="form-group">
          <label for="feelingExpression">Share more about how you felt:</label>
          <textarea id="feelingExpression" name="feelingExpression" class="chat-input" rows="3" placeholder="Express how you felt after the simulation..." maxlength="300"></textarea>
        </div>
        <button type="submit" class="feedback-submit">
          <span style="font-size:1.2em;vertical-align:middle;">🚀</span> See Statistics & Chat
        </button>
      </form>
    </section>
  </div>
</main>

<footer>
  <p>&copy; 2025 Empathy Simulator. All rights reserved.</p>
</footer>

<script>
  document.getElementById('feedbackForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const msgDiv = document.getElementById('formMessage');

    try {
      const response = await fetch(form.action, {
        method: 'POST',
        body: formData
      });

      if (!response.ok) throw new Error('Network response was not ok');

      const result = await response.json();

      if (result.success) {
        const name = result.name; // Use server-confirmed name
        window.location.href = `statistics.php?name=${encodeURIComponent(name)}`;
      } else {
        msgDiv.style.color = 'red';
        msgDiv.textContent = result.message;
      }
    } catch (error) {
      msgDiv.style.color = 'red';
      msgDiv.textContent = 'An error occurred. Please try again later.';
      console.error('Error:', error);
    }
  });

  document.getElementById('feelingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const feeling = document.getElementById('feeling').value;
    if (!feeling) return;
    window.location.href = `statistics.php?feeling=${encodeURIComponent(feeling)}`;
  });
</script>
<script src="script.js"></script>

</body>
</html>
