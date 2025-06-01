<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>
                <p>Employee</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="../employeeUI/activeDisplay.php" target="contentFrame" class="active">
                    <i class="fas fa-table"></i> Active Requests
                </a>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </div>
        
        <div class="main-content">
            <iframe name="contentFrame" class="iframe-container" src="../employeeUI/activeDisplay.php"></iframe>
        </div>
    </div>
    
    <script src="../ui/script.js"></script>
</body>
</html>