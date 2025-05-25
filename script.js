document.addEventListener('DOMContentLoaded', () => {
  const scenarios = {
    homeless: {
      steps: [
        { text: "You wake up in a shelter with a sore back from the hard floor.", image: "images/homeless1.jpg" },
        { text: "You walk the streets looking for food and kindness.", image: "images/homeless2.jpg" },
        { text: "Someone avoids you as you ask for change.", image: "images/homeless3.jpg" },
        { text: "You wait in line at a soup kitchen for a hot meal.", image: "images/homeless4.jpg" },
        { text: "At night, you try to find a safe place to sleep.", image: "images/homeless5.jpg" }
      ]
    },
    blind: {
      steps: [
        { text: "You navigate your apartment using touch and memory.", image: "images/blind1.jpg" },
        { text: "Crossing a street becomes an exercise in trust.", image: "images/blind2.jpg" },
        { text: "You miss your stop because you didn’t hear the announcement.", image: "images/blind3.jpg" },
        { text: "You ask a stranger to read a food label at the store.", image: "images/blind4.jpg" },
        { text: "You sit with your guide dog and reflect on the day’s challenges.", image: "images/blind5.jpg" }
      ]
    },
    refugee: {
      steps: [
        { text: "You flee your home with your family under the cover of night.", image: "images/refugee1.jpg" },
        { text: "You cross a border and are held for questioning.", image: "images/refugee2.jpg" },
        { text: "In a crowded camp, you wait days for any news of safety.", image: "images/refugee3.jpg" },
        { text: "Your child falls ill and medical help is limited.", image: "images/refugee4.jpg" },
        { text: "You fill out long forms, unsure if you’ll be accepted anywhere.", image: "images/refugee5.jpg" }
      ]
    },
    bullying: {
      steps: [
        { text: "You hear laughter and feel it’s about you.", image: "images/bullying1.jpg" },
        { text: "At home, your phone lights up with cruel messages.", image: "images/bullying2.jpg" },
        { text: "You try to ignore whispers in the hallway.", image: "images/bullying3.jpg" },
        { text: "A friend checks on you, offering a bit of hope.", image: "images/bullying4.jpg" },
        { text: "You consider skipping school to avoid the torment.", image: "images/bullying5.jpg" }
      ]
    },
    wheelchair: {
      steps: [
        { text: "You try to enter a building with no ramp.", image: "images/wheelchair1.jpg" },
        { text: "The elevator is broken. You’re stuck on the ground floor.", image: "images/wheelchair2.jpg" },
        { text: "You ask someone to help you reach a high shelf.", image: "images/wheelchair3.jpg" },
        { text: "People stare but rarely speak to you directly.", image: "images/wheelchair4.jpg" },
        { text: "You celebrate getting through the day despite obstacles.", image: "images/wheelchair5.jpg" }
      ]
    },
    anxiety: {
      steps: [
        { text: "Crowds make your breathing shallow. You freeze.", image: "images/anxiety1.jpg" },
        { text: "You pretend to browse so no one talks to you.", image: "images/anxiety2.jpg" },
        { text: "You rehearse your coffee order multiple times before entering.", image: "images/anxiety3.jpg" },
        { text: "You leave early, overwhelmed by noise and lights.", image: "images/anxiety4.jpg" },
        { text: "You make it home and reflect on the small victories.", image: "images/anxiety5.jpg" }
      ]
    }
  };

  const scenarioSelect = document.getElementById('scenarioSelect');
  const startBtn = document.getElementById('startBtn');
  const simulatorSection = document.getElementById('simulator');
  const stepImage = document.getElementById('stepImage');
  const storyText = document.getElementById('storyText');
  const optionsDiv = document.getElementById('options');
  const chatMessages = document.getElementById('chatMessages');

  let currentScenario = null;
  let currentStep = 0;

  startBtn.addEventListener('click', () => {
    const selected = scenarioSelect.value;
    if (!selected) return;

    currentScenario = scenarios[selected];
    currentStep = 0;
    simulatorSection.style.display = 'flex'; // or 'block'
    showStep();
  });

  function showStep() {
    const step = currentScenario.steps[currentStep];
    if (!step) {
      // Hide the old content
      storyText.textContent = "";
      stepImage.style.display = 'none';
      optionsDiv.innerHTML = "";

      // Show the end container and feedback section
      document.getElementById('endContainer').style.display = 'flex';
      document.getElementById('feedbackSection').style.display = 'block';

      // Set the thank you message in the left box
      document.getElementById('endMessage').innerHTML = "<h2 style='margin-top:0;'>Thank you for trying!</h2>";

      return;
    }

    stepImage.src = step.image;
    stepImage.style.display = 'block';
    storyText.textContent = step.text;

    optionsDiv.innerHTML = '';
    const nextBtn = document.createElement('button');
    nextBtn.className = 'option-btn';
    nextBtn.textContent = currentStep === currentScenario.steps.length - 1 ? "Finish" : "Continue";
    nextBtn.addEventListener('click', () => {
      currentStep++;
      showStep();
    });
    optionsDiv.appendChild(nextBtn);
  }

  window.submitReflection = function () {
    const reflection = document.getElementById('reflection').value;
    if (reflection.trim() === '') {
      alert("Please write a reflection before submitting.");
      return;
    }
    alert("Thank you for sharing your reflection!");
    document.querySelector('.reflection-box').innerHTML = "<p class='end-message'>Your reflection has been submitted. 🌟</p>";
  };

  document.getElementById('feelingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('name').value.trim();
    const feeling = document.getElementById('feeling').value;
    const expression = document.getElementById('feelingExpression').value.trim();
    if (!name || !feeling) return false;
    window.location.href = `statistics.php?name=${encodeURIComponent(name)}&feeling=${encodeURIComponent(feeling)}&expression=${encodeURIComponent(expression)}`;
    return false;
  });

  const feelingExpressionForm = document.getElementById('feelingExpressionForm');
  const feelingExpression = document.getElementById('feelingExpression');

  feelingExpressionForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const text = feelingExpression.value.trim();
    if (!text) return;
    const messages = JSON.parse(localStorage.getItem(chatKey) || "[]");
    messages.push({ name: userName, text, type: "feeling" });
    localStorage.setItem(chatKey, JSON.stringify(messages));
    feelingExpression.value = "";
    renderChat();
  });

  function renderChat() {
    chatMessages.innerHTML = "";
    const messages = JSON.parse(localStorage.getItem(chatKey) || "[]");
    messages.forEach(msg => {
      const div = document.createElement('div');
      if (msg.type === "feeling") {
        div.innerHTML = `<span class="user-label">${msg.name} expressed:</span> <em>${msg.text}</em>`;
        div.style.background = "#e6f7ff";
        div.style.borderRadius = "7px";
        div.style.padding = "7px 10px";
        div.style.marginBottom = "7px";
      } else {
        div.innerHTML = `<span class="user-label">${msg.name}:</span> ${msg.text}`;
      }
      chatMessages.appendChild(div);
    });
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }
});

