<?php
session_start();
include 'config.php'; // your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        // Prepare SQL to fetch user by username
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        if (!$stmt) {
            die("Database error: " . $conn->error);
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Check password hash
            if (password_verify($password, $user['password'])) {
                // Correct password, create session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Username not found.";
        }
        $stmt->close();
    } else {
        $error = "Please fill in both fields.";
    }
} else {
    // Redirect to login page if accessed without POST
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login - Empathy Simulator</title>
    <style>
        /* Add minimal styling for error message */
        .error { color: red; text-align: center; margin-top: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <?php if (!empty($error)) : ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <!-- Optional: Add a link back to the login form -->
    <p style="text-align:center;"><a href="login.php">Back to Login</a></p>
</body>
</html>
