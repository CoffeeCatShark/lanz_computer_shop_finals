<?php

session_start();
$conn = new mysqli('localhost', 'root', '', 'computer_shop');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $retypePassword = $_POST['retypePassword'];

    // Check if first user
    $result = $conn->query("SELECT COUNT(*) AS user_count FROM users");
    $row = $result->fetch_assoc();
    $isFirstUser = ($row['user_count'] == 0);
    $role = $isFirstUser ? 'admin' : 'employee';

    // Validations
    if (empty($username) || empty($email) || empty($password)) {
        die("All fields are required");
    }

    if ($password !== $retypePassword) {
        die("Passwords do not match");
    }

    if (strlen($password) < 8) {
        die("Password must be at least 8 characters");
    }

    // Check existing username
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo "<div style='color:red;'>Username already exists</div>";
        echo "<form action='register_page.php' method='get'>
                <button type='submit'>Back to Registration</button>
              </form>";
        exit();
    }

    // Check existing email
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo "<div style='color:red;'>Email is already in use</div>";
        echo "<form action='register_page.php' method='get'>
                <button type='submit'>Back to Registration</button>
              </form>";
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        header("Location: login_page.php");
        exit();
    } else {
        die("Registration failed: " . $conn->error);
    }
}
?>