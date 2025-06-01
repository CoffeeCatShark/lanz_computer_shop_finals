
<?php
include '../conn.php';
$query_ = "SELECT * FROM request_table
           JOIN active_table ON request_table.request_id = active_table.request_id
           ORDER BY request_table.timestamp";
$fetchResult = mysqli_query($conn, $query_);
$rowCount = mysqli_num_rows($fetchResult);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Active Requests</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="table-container fade-in">
        <div class="page-header">
            <h1><i class="fas fa-clock"></i> Active Requests</h1>
        </div>
        
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Service Type</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>File Upload</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($rowCount > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($fetchResult)): ?>
                        <tr class="fade-in">
                            <td><?= htmlspecialchars($row['service_type']) ?></td>
                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                            <td><?= date("M j, Y", strtotime($row['timestamp'])) ?></td>
                            <td><?= date("g:i A", strtotime($row['timestamp'])) ?></td>
                            <td>
                                <?php if($row['file_upload'] != "../docs/"): ?>
                                    <a href="../docs/file-viewer.php?file=<?= urlencode($row['file_upload']) ?>" class="file-link">
                                        <i class="fas fa-eye"></i> View File
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="btn btn-delete" href="remove-active.php?id=<?= $row['request_index'] ?>&id2=<?= $row['active_index'] ?>">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="no-requests">No active requests found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="action-buttons">
            <a href="../Prototype_access_control/admin_dashboard.php" target="_parent" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
    
    <script src="../ui/script.js"></script>
</body>
</html>
