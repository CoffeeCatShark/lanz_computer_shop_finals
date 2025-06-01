<?php
require '../conn.php';
$id = $_GET['id'];

$sql = "SELECT * FROM service_table where service_index='$id'";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $description = $row['service_type'];            
        $service_id = $row['service_id'];                    
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Service</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="confirmation-container">
        <div class="confirmation-header">
            <h2><i class="fas fa-trash-alt"></i> Delete Service</h2>
        </div>
        
        <form class="confirmation-form" action="delete-confirm-admin.php" method="post">
            <div class="form-row">
                <label>Service Description:</label>
                <input readonly type="text" name="service_desc" value="<?= htmlspecialchars($description) ?>">
            </div>
            
            <div class="form-row">
                <label>Service ID:</label>
                <input readonly type="text" name="serviceID" value="<?= htmlspecialchars($service_id) ?>">
                <input type="hidden" value="<?= htmlspecialchars($id) ?>" name="index">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Confirm Delete
                </button>
                <a href="service-admin.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>