<?php
include '../conn.php';
$query = "SELECT * FROM service_table ORDER BY service_id";
$serviceResult = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Service Display</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="table-container fade-in">
        <div class="page-header">
            <h1><i class="fas fa-cogs"></i> Service Management</h1>
        </div>
        
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Service ID</th>
                        <th>Service Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($serviceResult)): ?>
                    <tr class="fade-in">
                        <td><?= htmlspecialchars($row['service_id']) ?></td>
                        <td><?= htmlspecialchars($row['service_type']) ?></td>
                        <td>
                            <a class="btn btn-edit" href="edit-service.php?id=<?= $row['service_index'] ?>">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-delete" href="delete-service.php?id=<?= $row['service_index'] ?>">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <div class="action-buttons">
            <a href="add-service.php" class="primary-btn">
                <i class="fas fa-plus"></i> Add New Service
            </a>
            <a href="../Prototype_access_control/admin_dashboard.php" target="_parent" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
    
    <script src="../ui/script.js"></script>
</body>
</html>