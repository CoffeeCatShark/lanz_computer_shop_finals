<?php
require '../conn.php';
$index = $_GET['id'];

$sql = "SELECT * FROM service_table where service_index='$index'";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $type = $row['service_type'];            
        $service_id = $row['service_id'];                    
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="confirmation-container">
        <div class="confirmation-header">
            <h2><i class="fas fa-edit"></i> Edit Service</h2>
        </div>
        
        <form class="confirmation-form" action="edit-confirm-admin.php" method="post">
            <div class="form-row">
                <label>Service Description:</label>
                <input required type="text" name="service_desc" value="<?= htmlspecialchars($type) ?>">
            </div>
            
            <div class="form-row">
                <label>Service ID:</label>
                <input required type="text" name="serviceID" value="<?= htmlspecialchars($service_id) ?>">
                <input type="hidden" name="index" value="<?= htmlspecialchars($index) ?>">
                <input type="hidden" name="oldID" value="<?= htmlspecialchars($service_id) ?>">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="service-admin.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>