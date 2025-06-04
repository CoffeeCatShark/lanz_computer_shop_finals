<?php
require_once 'auth_check.php';

$conn = new mysqli('localhost', 'root', '', 'computer_shop');

// Get employees
$result = $conn->query("SELECT id, username FROM users WHERE role='employee'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int)$_POST['user_id'];
    $conn->query("UPDATE users SET role='admin' WHERE id=$user_id");
    header("Location: admin_dashboard.php");
    exit();
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
        
        <form class="promote-form" method="POST" action="">
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
                <a href="admin_dashboard.php" target="_parent" class="promote-btn promote-btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </form>
    </div>
</body>
</html>