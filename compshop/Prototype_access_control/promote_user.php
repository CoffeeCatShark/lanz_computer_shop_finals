<?php
require_once 'auth_check.php';

$conn = new mysqli('localhost', 'root', '', 'computer_shop');

// Get employees
$result = $conn->query("SELECT id, username FROM users WHERE role='employee'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        // Promote user to admin
        $user_id = (int)$_POST['user_id'];
        $conn->query("UPDATE users SET role='admin' WHERE id=$user_id");
        header("Location: admin_dashboard.php");
        exit();
    } elseif (isset($_POST['delete_self'])) {
        // Delete current admin account
        $current_user_id = $_SESSION['user_id'];
        $conn->query("DELETE FROM users WHERE id=$current_user_id");
        
        // Logout and redirect to login page
        session_destroy();
        header("Location: ../login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Promote Users</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="promote-container fade-in">
        <div class="promote-header">
            <h1><i class="fas fa-user-shield"></i> Promote to Administrator</h1>
        </div>
        
        <form class="promote-form" method="POST">
            <div class="form-group">
                <select class="promote-select" name="user_id" required>
                    <option value="" disabled selected>Select Employee</option>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['username'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="promote-actions">
                <button type="submit" class="promote-btn promote-btn-primary">
                    <i class="fas fa-user-plus"></i> Promote to Admin
                </button>
            </div>
            
            <div class="action-buttons">
                <a href="welcome.php" target="_parent" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </form>
    </div>
    
    <!-- Separate Account Management Box -->
    <div class="account-management-container fade-in">
        <div class="account-management-header">
            <i class="fas fa-user-cog"></i> Account Management
        </div>
        <form method="POST" onsubmit="return confirm('WARNING: This will permanently delete your account. Are you sure you want to continue?');">
            <input type="hidden" name="delete_self" value="1">
            <button type="submit" class="delete-self-btn">
                <i class="fas fa-trash-alt"></i> Delete My Account
            </button>
        </form>
    </div>
</body>
</html>