<?php
require_once '../conn.php';

// Get total users count
$users_query = "SELECT COUNT(*) as total_users FROM users";
$users_result = mysqli_query($conn, $users_query);
$users_data = mysqli_fetch_assoc($users_result);
$total_users = $users_data['total_users'];

// Get active requests count
$active_query = "SELECT COUNT(*) as active_requests FROM active_table";
$active_result = mysqli_query($conn, $active_query);
$active_data = mysqli_fetch_assoc($active_result);
$active_requests = $active_data['active_requests'];

// Get completed requests count (today)
$today = date('Y-m-d');
$completed_query = "SELECT COUNT(*) as completed_today FROM request_table 
                   WHERE DATE(timestamp) = '$today' AND request_id NOT IN 
                   (SELECT request_id FROM active_table)";
$completed_result = mysqli_query($conn, $completed_query);
$completed_data = mysqli_fetch_assoc($completed_result);
$completed_today = $completed_data['completed_today'];

// Get services count
$services_query = "SELECT COUNT(*) as total_services FROM service_table";
$services_result = mysqli_query($conn, $services_query);
$services_data = mysqli_fetch_assoc($services_result);
$total_services = $services_data['total_services'];

// Get recent activities
$activities_query = "SELECT 
                    CASE 
                        WHEN r.request_id IS NOT NULL THEN CONCAT('New request #', r.request_id, ' (', r.service_type, ')')
                        ELSE 'System activity'
                    END as activity_title,
                    r.timestamp as activity_time,
                    CASE 
                        WHEN r.request_id IS NOT NULL THEN 'fa-tasks'
                        ELSE 'fa-cog'
                    END as activity_icon
                    FROM request_table r
                    ORDER BY r.timestamp DESC
                    LIMIT 4";
$activities_result = mysqli_query($conn, $activities_query);
$recent_activities = mysqli_fetch_all($activities_result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .welcome-container {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 2rem;
            background: #f8fafc;
            border-radius: 8px;
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .dashboard-header h1 {
            color: #2c3e50;
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border-left: 4px solid #3498db;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }
        
        .stat-card.orange {
            border-left-color: #e67e22;
        }
        
        .stat-card.green {
            border-left-color: #2ecc71;
        }
        
        .stat-card.purple {
            border-left-color: #9b59b6;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0.5rem 0;
        }
        
        .stat-label {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin: 0;
        }
        
        .stat-icon {
            font-size: 1.5rem;
            color: #3498db;
        }
        
        .stat-card.orange .stat-icon {
            color: #e67e22;
        }
        
        .stat-card.green .stat-icon {
            color: #2ecc71;
        }
        
        .stat-card.purple .stat-icon {
            color: #9b59b6;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
            width: 100%;
        }
        
        .feature-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 2rem;
            color: #3498db;
            margin-bottom: 1rem;
            background: #ebf5fb;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .feature-card h3 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }
        
        .feature-card p {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin: 0;
            line-height: 1.5;
        }
        
        .recent-activity {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        .section-title {
            color: #2c3e50;
            font-size: 1.3rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            font-size: 1.2rem;
            color: #3498db;
            margin-right: 1rem;
            background: #ebf5fb;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-title {
            color: #2c3e50;
            font-weight: 500;
            margin: 0 0 0.25rem 0;
        }
        
        .activity-time {
            color: #7f8c8d;
            font-size: 0.8rem;
            margin: 0;
        }
        
        .current-time {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="dashboard-header">
            <h1>Dashboard Overview</h1>
            <div class="current-time" id="current-time"></div>
        </div>
        
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value"><?php echo $total_users; ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            
            <div class="stat-card orange">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-value"><?php echo $active_requests; ?></div>
                <div class="stat-label">Active Requests</div>
            </div>
            
            
            
            <div class="stat-card purple">
                <div class="stat-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="stat-value"><?php echo $total_services; ?></div>
                <div class="stat-label">Services</div>
            </div>
        </div>
        
        <div class="features-grid">
            <div class="feature-card fade-in delay-1">
                <div class="feature-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3>User Management</h3>
                <p>Manage user roles, permissions, and access levels for all system users</p>
            </div>
            
            <div class="feature-card fade-in delay-2">
                <div class="feature-icon">
                    <i class="fas fa-table"></i>
                </div>
                <h3>Active Requests</h3>
                <p>Monitor and manage all currently active service requests in real-time</p>
            </div>
            
            <div class="feature-card fade-in delay-3">
                <div class="feature-icon">
                    <i class="fas fa-list"></i>
                </div>
                <h3>Request Tracking</h3>
                <p>Track and process all incoming service requests efficiently</p>
            </div>
            
            <div class="feature-card fade-in delay-4">
                <div class="feature-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <h3>Service Management</h3>
                <p>Configure and maintain available services and their settings</p>
            </div>
        </div>
        
        <div class="recent-activity">
            <h3 class="section-title">Recent Activity</h3>
            
            <?php if (!empty($recent_activities)): ?>
                <?php foreach ($recent_activities as $activity): ?>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas <?php echo $activity['activity_icon']; ?>"></i>
                        </div>
                        <div class="activity-content">
                            <h4 class="activity-title"><?php echo htmlspecialchars($activity['activity_title']); ?></h4>
                            <p class="activity-time">
                                <?php 
                                    $time = strtotime($activity['activity_time']);
                                    echo date('M j, g:i A', $time);
                                ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No recent activity found</p>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            document.getElementById('current-time').textContent = now.toLocaleDateString('en-US', options);
        }
        
        updateTime();
        setInterval(updateTime, 60000); // Update every minute
    </script>
</body>
</html>