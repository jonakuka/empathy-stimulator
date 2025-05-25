<?php
// statistics.php

// Load feedback data (JSON file)
$file = 'feedback_data.json';

$data = [];
if (file_exists($file)) {
    $data = json_decode(file_get_contents($file), true);
    if (!is_array($data)) {
        $data = [];
    }
}

// Simulated breakdown by scenario (if your data is not structured like this, you can adapt)
$scenario_feedback = [
    'homeless' => [
        'empathized_a_lot' => 5,
        'somewhat_empathized' => 3,
        'did_not_relate' => 1,
    ],
    'blind' => [
        'empathized_a_lot' => 2,
        'somewhat_empathized' => 4,
        'did_not_relate' => 2,
    ],
    'refugee' => [
        'empathized_a_lot' => 6,
        'somewhat_empathized' => 2,
        'did_not_relate' => 0,
    ],
    // Add other scenarios or aggregate as you wish
];

// Flatten total counts (sum across scenarios)
$total_counts = [
    'empathized_a_lot' => 0,
    'somewhat_empathized' => 0,
    'did_not_relate' => 0,
];
foreach ($scenario_feedback as $scenario => $counts) {
    foreach ($counts as $key => $val) {
        $total_counts[$key] += $val;
    }
}

$labels = [
    'empathized_a_lot' => 'I empathized a lot',
    'somewhat_empathized' => 'I somewhat empathized',
    'did_not_relate' => 'I did not relate',
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Advanced Feedback Statistics - Empathy Simulator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f9fafb;
      margin: 0; padding: 0;
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header, footer {
      background: #6C63FF;
      color: white;
      padding: 15px 30px;
      text-align: center;
      font-weight: 600;
      font-size: 1.2rem;
      letter-spacing: 0.03em;
    }
    nav .nav-links {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: center;
      gap: 30px;
    }
    nav .nav-links li a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      padding: 8px 16px;
      border-radius: 6px;
      transition: background-color 0.3s ease;
    }
    nav .nav-links li a:hover {
      background-color: rgba(255 255 255 / 0.2);
    }
    main {
      flex-grow: 1;
      max-width: 900px;
      margin: 80px auto 50px;
      background: white;
      padding: 30px 40px;
      border-radius: 14px;
      box-shadow: 0 12px 28px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      color: #4a47a3;
      margin-bottom: 25px;
      font-weight: 700;
      font-size: 2rem;
    }

    .filter-section {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-bottom: 30px;
      flex-wrap: wrap;
    }
    select, button {
      padding: 8px 14px;
      font-size: 1rem;
      border-radius: 6px;
      border: 1.5px solid #6C63FF;
      background: white;
      color: #4a47a3;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.25s ease;
      min-width: 180px;
    }
    select:hover, button:hover {
      background-color: #6C63FF;
      color: white;
    }
    #resetBtn {
      background-color: #e55353;
      border-color: #d43d3d;
      color: white;
    }
    #resetBtn:hover {
      background-color: #c13030;
    }

    .chart-container {
      display: flex;
      gap: 50px;
      flex-wrap: wrap;
      justify-content: center;
    }
    .chart-box {
      flex: 1 1 400px;
      max-width: 450px;
      background: #fafafa;
      padding: 25px 20px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(108, 99, 255, 0.12);
    }
    canvas {
      display: block;
      max-width: 100%;
      margin: 0 auto;
    }
    .footer-note {
      text-align: center;
      font-style: italic;
      margin-top: 40px;
      color: #666;
      font-size: 1rem;
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
      font-size: 1.8em;
      font-weight: bold;
      letter-spacing: 1px;
      background: linear-gradient(45deg, #ffcc70, #6c63ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      cursor: default;
      user-select: none;
      transition: transform 0.3s ease;
    }
    .logo:hover {
      transform: scale(1.1);
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
  </style>
</head>
<body>
  <header>
    <nav class="navbar" role="navigation" aria-label="Main Navigation">
      <div class="logo">Empathy Simulator</div>
      <ul class="nav-links">
        <li><a href="empathy_simulator.html">Empathy Simulator</a></li>
        <li><a href="empathy_quiz.php">Empathy Quiz or Test</a></li>
        <li><a href="anonymous_advice_wall.php">Anonymous Advice Wall</a></li>
        <li><a href="art_gallery.php">Empathy Art</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h1>Feedback Statistics Dashboard</h1>

    <section class="filter-section" aria-label="Filter feedback by scenario">
      <select id="scenarioFilter" aria-label="Select scenario filter">
        <option value="all" selected>All Scenarios</option>
        <?php foreach ($scenario_feedback as $scenario => $_): ?>
          <option value="<?= htmlspecialchars($scenario) ?>"><?= ucfirst(htmlspecialchars($scenario)) ?></option>
        <?php endforeach; ?>
      </select>
      <button id="resetBtn" aria-label="Reset filters">Reset Filters</button>
    </section>

    <section class="chart-container" aria-label="Feedback charts">
      <div class="chart-box">
        <h2 style="text-align:center; color:#4a47a3;">Bar Chart - Empathy Levels</h2>
        <canvas id="barChart" aria-describedby="barChartDesc"></canvas>
        <p id="barChartDesc" class="footer-note">Bar chart showing count of each empathy response.</p>
      </div>
      <div class="chart-box">
        <h2 style="text-align:center; color:#4a47a3;">Doughnut Chart - Empathy Distribution</h2>
        <canvas id="doughnutChart" aria-describedby="doughnutChartDesc"></canvas>
        <p id="doughnutChartDesc" class="footer-note">Doughnut chart showing percentage distribution of empathy responses.</p>
      </div>
    </section>

    <p id="currentScenarioLabel" style="text-align:center; margin-top: 30px; font-weight:600; font-size:1.2rem; color:#5e4a9f;">
      Showing feedback for: All Scenarios
    </p>
  </main>

  <footer>
    &copy; <?= date("Y") ?> Empathy Simulator — Building Understanding One Story at a Time
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Feedback data from PHP embedded into JS
    const scenarioFeedback = <?php
      // Send PHP data as JSON for all scenarios
      echo json_encode($scenario_feedback, JSON_THROW_ON_ERROR);
    ?>;

    // Total counts for "all" scenarios
    const totalCounts = <?php
      echo json_encode($total_counts, JSON_THROW_ON_ERROR);
    ?>;

    const labelsMap = <?php
      echo json_encode($labels, JSON_THROW_ON_ERROR);
    ?>;

    let currentScenario = 'all';

    // Utility to get feedback data for selected scenario or total
    function getDataForScenario(scenario) {
      if (scenario === 'all') {
        return totalCounts;
      }
      return scenarioFeedback[scenario] || {
        empathized_a_lot: 0,
        somewhat_empathized: 0,
        did_not_relate: 0
      };
    }

    // Chart variables
    let barChartInstance = null;
    let doughnutChartInstance = null;

    // Create or update charts
    function createCharts(data) {
      const chartLabels = Object.keys(data).map(key => labelsMap[key] || key);
      const chartData = Object.values(data);

      // Bar chart config
      const barConfig = {
        type: 'bar',
        data: {
          labels: chartLabels,
          datasets: [{
            label: 'Number of Responses',
            data: chartData,
            backgroundColor: [
              '#6c63ff',
              '#a799ff',
              '#d9d7ff'
            ],
            borderRadius: 6,
            barPercentage: 0.7,
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              ticks: { stepSize: 1 }
            }
          },
          plugins: {
            legend: { display: false }
          }
        }
      };

      // Doughnut chart config
      const doughnutConfig = {
        type: 'doughnut',
        data: {
          labels: chartLabels,
          datasets: [{
            data: chartData,
            backgroundColor: [
              '#6c63ff',
              '#a799ff',
              '#d9d7ff'
            ],
            hoverOffset: 28,
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom',
              labels: { font: { size: 14 }, color: '#4a47a3' }
            },
            tooltip: {
              callbacks: {
                label: context => {
                  const label = context.label || '';
                  const value = context.parsed || 0;
                  const total = context.dataset.data.reduce((a,b) => a+b, 0);
                  const percent = total ? ((value / total) * 100).toFixed(1) : 0;
                  return `${label}: ${value} (${percent}%)`;
                }
              }
            }
          }
        }
      };

      // Update or create bar chart
      if (barChartInstance) {
        barChartInstance.data = barConfig.data;
        barChartInstance.options = barConfig.options;
        barChartInstance.update();
      } else {
        const ctxBar = document.getElementById('barChart').getContext('2d');
        barChartInstance = new Chart(ctxBar, barConfig);
      }

      // Update or create doughnut chart
      if (doughnutChartInstance) {
        doughnutChartInstance.data = doughnutConfig.data;
        doughnutChartInstance.options = doughnutConfig.options;
        doughnutChartInstance.update();
      } else {
        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        doughnutChartInstance = new Chart(ctxDoughnut, doughnutConfig);
      }
    }

    // Update displayed scenario name
    function updateScenarioLabel(scenario) {
      const scenarioNames = {
        all: 'All Scenarios',
        homeless: 'A Day as a Homeless Teen',
        blind: 'Navigating Life Without Sight',
        refugee: 'Fleeing Home as a Refugee',
        bullying: 'Living with School Bullying',
        wheelchair: 'Life in a Wheelchair',
        anxiety: 'Struggling with Anxiety in Public'
      };
      document.getElementById('currentScenarioLabel').textContent = 
        `Showing feedback for: ${scenarioNames[scenario] || scenario}`;
    }

    // Update charts and label for the chosen scenario
    function updateCharts() {
      const data = getDataForScenario(currentScenario);
      createCharts(data);
      updateScenarioLabel(currentScenario);
    }

    // DOM event listeners
    document.getElementById('scenarioFilter').addEventListener('change', e => {
      currentScenario = e.target.value;
      updateCharts();
    });

    document.getElementById('resetBtn').addEventListener('click', () => {
      currentScenario = 'all';
      document.getElementById('scenarioFilter').value = 'all';
      updateCharts();
    });

    // Initial chart rendering on page load
    updateCharts();

  </script>
</body>
</html>
