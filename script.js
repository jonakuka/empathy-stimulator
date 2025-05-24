const scenarios = {
  "homeless": [
    {
      text: "You wake up on a bench. It's freezing and you haven’t eaten in a day.",
      options: [
        { text: "Look for food", next: 1 },
        { text: "Find shelter", next: 2 }
      ]
    },
    {
      text: "You search trash bins. A store owner yells at you to leave.",
      options: [
        { text: "Apologize", next: 3 },
        { text: "Run away", next: 4 }
      ]
    },
    {
      text: "You go to a shelter. It’s full. You sleep outside again.",
      options: []
    },
    {
      text: "The store owner calms down. He offers leftover food.",
      options: []
    },
    {
      text: "You run and sprain your ankle. It hurts to move.",
      options: []
    }
  ],
  "blind": [
    {
      text: "You need to cross a busy street. You can only hear the traffic.",
      options: [
        { text: "Wait for someone to help", next: 1 },
        { text: "Try to cross alone", next: 2 }
      ]
    },
    {
      text: "No one comes. You wait 10 minutes.",
      options: []
    },
    {
      text: "A car honks. You panic mid-crossing.",
      options: []
    }
  ]
};

let currentStep = 0;
let currentScenario = [];

function startSimulation() {
  const choice = document.getElementById("scenarioSelect").value;
  currentScenario = scenarios[choice];
  currentStep = 0;
  document.getElementById("simulator").style.display = "block";
  document.getElementById("feedbackSection").style.display = "none"; // reset
  showStep();
}

function showStep() {
  const step = currentScenario[currentStep];
  document.getElementById("storyText").innerText = step.text;

  const optionsDiv = document.getElementById("options");
  optionsDiv.innerHTML = "";

 if (step.options.length === 0) {
  const endMsg = document.createElement("p");
  endMsg.innerText = "Simulation complete. What did you feel?";
  optionsDiv.appendChild(endMsg);

  // SHOW FEEDBACK BOX
  document.getElementById("feedbackSection").style.display = "block";
  return;
}

    // Show the feedback box
    document.getElementById("feedbackSection").style.display = "block";
    return;
  }

  step.options.forEach(opt => {
    const btn = document.createElement("button");
    btn.innerText = opt.text;
    btn.onclick = () => {
      currentStep = opt.next;
      showStep();
    };
    optionsDiv.appendChild(btn);
  });


function submitFeedback() {
  const feedback = document.getElementById("feedbackText").value.trim();

  if (!feedback) {
    alert("Please share your thoughts before submitting.");
    return;
  }

  alert("Thank you for your feedback!");
  document.getElementById("feedbackSection").style.display = "none";
  document.getElementById("feedbackText").value = "";
}



