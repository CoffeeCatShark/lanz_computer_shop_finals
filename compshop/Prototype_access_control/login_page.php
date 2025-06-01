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
        <meta charset="utf-8">
        <title>Main Access Control Prototype</title>
        <link rel="stylesheet" href="../ui/styles.css">
    </head>
    <body>
        <div class="login-container">
            <div class="login-box">
                <h1>Admin/Employee Login</h1>
                <form id="loginForm" method="POST" action="login.php" class="login-form">
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
                        <p>Don't have an Account? <a href="register_page.php"><b>Register</b></a></p>
                    </div>
                </form>
            </div>
        </div>
        <script src="../ui/script.js"></script>
    </body>
</html>