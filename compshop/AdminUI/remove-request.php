<?php
require_once '../Prototype_access_control/auth_check.php';
include '../conn.php';
$index = $_GET['id'];
$activeid = $_GET['id2'];

$sql = "SELECT * FROM request_table where request_index='$index'";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id = $row['request_id'];
        $type = $row['service_type'];
        $fllname = $row['customer_name'];
        $time = $row['timestamp'];
        $file = $row['file_upload'];        
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Remove Request</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="confirmation-container">
        <div class="confirmation-header">
            <h2><i class="fas fa-exclamation-triangle"></i> Remove Request?</h2>
        </div>
        
        <form class="confirmation-form" action="remove-confirm-admin.php" method="post">
            <div class="form-row">
                <label>ID:</label>
                <input readonly type="text" name="id" value="<?= htmlspecialchars($id) ?>">
            </div>
            
            <div class="form-row">
                <label>Service Type:</label>
                <input readonly type="text" name="serviceID" value="<?= htmlspecialchars($type) ?>">
            </div>
            
            <div class="form-row">
                <label>Customer Name:</label>
                <input readonly type="text" value="<?= htmlspecialchars($fllname) ?>">
                <input type="hidden" value="<?= htmlspecialchars($id) ?>" name="index">
            </div>
            
            <div class="form-row">
                <label>Time:</label>
                <input readonly type="text" value="<?= htmlspecialchars($time) ?>">
            </div>
            
            <div class="form-row">
                <label>File:</label>
                <input readonly type="text" value="<?= htmlspecialchars($file) ?>">
                <input type="hidden" value="<?= htmlspecialchars($index) ?>" name="index">
                <input type="hidden" value="<?= htmlspecialchars($activeid) ?>" name="id">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Confirm Removal
                </button>
                <a href="request-admin.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>