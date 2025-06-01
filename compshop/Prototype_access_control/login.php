<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: ".($_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : 'employee_dashboard.php'));
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'computer_shop');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            header("Location: ".($user['role'] === 'admin' ? 'admin_dashboard.php' : 'employee_dashboard.php'));
            exit();
        }
    }
    $error = "Invalid credentials";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../ui/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>System Login</h1>
            <?php if(isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php" class="login-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit">Login</button>
                <div class="login-links">
                    <p>Don't have an account? <a href="register_page.php">Register here</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="../ui/script.js"></script>
</body>
</html>