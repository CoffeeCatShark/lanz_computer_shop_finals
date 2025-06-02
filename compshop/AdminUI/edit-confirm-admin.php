<?php
include '../conn.php';

$index = $_POST['index'];
$oldID = $_POST['oldID'];
$desc = $_POST['service_desc'];
$newID = $_POST['serviceID'];

$isDup = 0;

if($newID==$oldID) {
    $isDup=0;
} else {
    $sql = "SELECT * FROM service_table WHERE Service_Id = '$newID'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $isDup+=1;
        }
    }
}

if($isDup == 0) {
    $conn->query("UPDATE service_table SET service_id = '$newID', service_type = '$desc' WHERE Service_Index = '$index'");
    $message = "Service updated successfully!";
    $messageClass = "message-success";
    $icon = "fa-check-circle";
} else {
    $message = "Error: Service ID already exists!";
    $messageClass = "message-error";
    $icon = "fa-exclamation-circle";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Service Confirmation</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="confirmation-container">
        <div class="confirmation-header">
            <h2><i class="fas <?php echo $icon; ?>"></i> <?php echo $isDup == 0 ? 'Edit Confirmation' : 'Edit Error'; ?></h2>
        </div>
        
        <div class="message-box <?php echo $messageClass; ?>">
            <i class="fas <?php echo $icon; ?>"></i> <?php echo $message; ?>
        </div>
        
        <div class="confirmation-details">
            <div class="form-row">
                <label><i class="fas fa-hashtag"></i> Service Index:</label>
                <input type="text" value="<?php echo htmlspecialchars($index); ?>" readonly>
            </div>
            
            <div class="form-row">
                <label><i class="fas fa-id-card"></i> Original Service ID:</label>
                <input type="text" value="<?php echo htmlspecialchars($oldID); ?>" readonly>
            </div>
            
            <div class="form-row">
                <label><i class="fas fa-id-card"></i> New Service ID:</label>
                <input type="text" value="<?php echo htmlspecialchars($newID); ?>" readonly>
            </div>
            
            <div class="form-row">
                <label><i class="fas fa-align-left"></i> Service Description:</label>
                <input type="text" value="<?php echo htmlspecialchars($desc); ?>" readonly>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="service-admin.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Services
            </a>
            
            <?php if($isDup > 0): ?>
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-edit"></i> Try Again
            </a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>