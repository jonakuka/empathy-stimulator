<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Empathy Simulator</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #c3ecf7, #a7bcff);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .register-container {
      background: white;
      padding: 2.5rem 3rem;
      border-radius: 16px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .register-container h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
    }

    .form-group {
      margin-bottom: 1.2rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    input {
      width: 100%;
      padding: 0.75rem;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }

    input:focus {
      border-color: #6c63ff;
      outline: none;
    }

    button {
      width: 100%;
      padding: 0.85rem;
      background: #6c63ff;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #5848e5;
    }

    .login-link {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.95rem;
    }

    .login-link a {
      color: #6c63ff;
      text-decoration: none;
      font-weight: 600;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    /* Message styles */
    #message {
      margin-top: 1rem;
      font-weight: 600;
      text-align: center;
    }
    #message.success {
      color: green;
    }
    #message.error {
      color: red;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Create Your Account</h2>
    <form id="registerForm" action="register_process.php" method="post" novalidate>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required />
      </div>
      <div class="form-group">
        <label for="confirm">Confirm Password</label>
        <input type="password" name="confirm" id="confirm" required />
      </div>
      <button type="submit">Register</button>
    </form>
    <div id="message"></div>
    <div class="login-link">
      Already have an account? <a href="login.php">Login here</a>
    </div>
  </div>

  <script>
    const form = document.getElementById('registerForm');
    const messageDiv = document.getElementById('message');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      messageDiv.textContent = 'Processing...';
      messageDiv.className = '';

      const formData = new FormData(form);

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          body: formData
        });

        if (!response.ok) throw new Error('Network error');

        const data = await response.json();

        if (data.success) {
          messageDiv.className = 'success';
          messageDiv.textContent = data.message;
          form.reset();
        } else {
          messageDiv.className = 'error';
          messageDiv.textContent = data.message;
        }
      } catch (error) {
        messageDiv.className = 'error';
        messageDiv.textContent = 'An error occurred. Please try again later.';
        console.error(error);
      }
    });
  </script>
</body>
</html>
