<?php
include '../conn.php';
require_once '../Prototype_access_control/auth_check.php';
$filtervalues = isset($_GET['search']) ? $_GET['search'] : '';
$requery = "SELECT * FROM request_table WHERE CONCAT(`service_type`,`customer_name`,`timestamp`) LIKE '%$filtervalues%' ORDER BY `timestamp`";
$requestResult = mysqli_query($conn, $requery);
$rowCount = mysqli_num_rows($requestResult);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Display</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="table-container fade-in">
        <div class="page-header">
            <h1><i class="fas fa-list"></i> Service Requests</h1>
        </div>
        
        <form class="search-form fade-in delay-1" action="" method="get">
            <input type="text" name="search" placeholder="Search requests..." value="<?= htmlspecialchars($filtervalues) ?>">
            <button type="submit" class="action-btn">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
        
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Service Type</th>
                        <th>Customer Name</th>
                        <th>Time</th>
                        <th>File Upload</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($rowCount > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($requestResult)): ?>
                        <tr class="fade-in">
                            <td><?= htmlspecialchars($row['service_type']) ?></td>
                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                            <td><?= date("g:i A", strtotime($row['timestamp'])) ?></td>
                            <td>
                                <?php if($row['file_upload'] != "../docs/"): ?>
                                    <a href="../docs/file-viewer.php?file=<?= urlencode($row['file_upload']) ?>" class="file-link">
                                        <i class="fas fa-eye"></i> View File
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="btn btn-delete" href="remove-request.php?id=<?= $row['request_index'] ?>&id2=<?= $row['request_id'] ?>">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-requests">No requests found</td>
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

<?php
include '../conn.php';

$filtervalues = isset($_GET['search']) ? $_GET['search'] : '';
$requery = "SELECT * FROM request_table WHERE CONCAT(`service_type`,`customer_name`,`timestamp`) LIKE '%$filtervalues%' ORDER BY `timestamp`";
$requestResult = mysqli_query($conn, $requery);
$rowCount = mysqli_num_rows($requestResult);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Display</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="table-container fade-in">
        <div class="page-header">
            <h1><i class="fas fa-list"></i> Service Requests</h1>
        </div>
        
        <form class="search-form fade-in delay-1" action="" method="get">
            <input type="text" name="search" placeholder="Search requests..." value="<?= htmlspecialchars($filtervalues) ?>">
            <button type="submit" class="action-btn">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
        
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
                        <?php while($row = mysqli_fetch_assoc($requestResult)): ?>
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
                                <a class="btn btn-delete" href="remove-request.php?id=<?= $row['request_index'] ?>&id2=<?= $row['request_id'] ?>">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-requests">No requests found</td>
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