<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: ".($_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : 'employee_dashboard.php'));
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="../ui/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>System Registration</h1>
            <?php if(isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST" action="register.php" class="login-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password (min 8 chars):</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="retypePassword">Retype Password:</label>
                    <input type="password" id="retypePassword" name="retypePassword" required>
                </div>
                
                <button type="submit">Register</button>
                <div class="login-links">
                    <p>Already have an account? <a href="login_page.php">Login here</a></p>
                    <p class="small-note">First registrant will become system administrator</p>
                </div>
            </form>
        </div>
    </div>
    <script src="../ui/script.js"></script>
</body>
</html>