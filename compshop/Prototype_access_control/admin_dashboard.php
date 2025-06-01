<?php require_once 'auth_check.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>
                <p>Administrator</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="welcome.php" class="active">
                    <i class="fas fa-home"></i> Welcome Page
                </a>
                <a href="promote_user.php" class="fade-in delay-1">
                    <i class="fas fa-user-shield"></i> Manage User Roles
                </a>
                <a href="../AdminUI/delete_employee.php" class="fade-in delay-2">
                    <i class="fas fa-user-times"></i> Delete Employee
                </a>
                <a href="../AdminUI/admin-activedisplay.php" class="fade-in delay-3">
                    <i class="fas fa-table"></i> Active Table Display
                </a>
                <a href="../AdminUI/request-admin.php?search=" class="fade-in delay-4">
                    <i class="fas fa-list"></i> Request Table Display
                </a>
                <a href="../AdminUI/service-admin.php" class="fade-in delay-5">
                    <i class="fas fa-cogs"></i> Service Table Display
                </a>
                <a href="logout.php" class="logout-btn fade-in">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </div>
        
        <div class="main-content">
            <iframe class="iframe-container" src="welcome.php" loading="eager"></iframe>
        </div>
    </div>
    
    <script src="../ui/script.js"></script>
</body>
</html>