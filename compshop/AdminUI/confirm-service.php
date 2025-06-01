<?php
include '../conn.php';

$serviceName = $_POST['service_name'];
$serviceID = $_POST['service_id'];

$isDup = 0;
$sql = "SELECT * FROM service_table WHERE service_id='$serviceID' ORDER BY service_index";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $isDup += 1;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Confirm Service</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="confirmation-container">
        <div class="confirmation-header">
            <h2><i class="fas fa-check-circle"></i> Service Confirmation</h2>
        </div>
        
        <?php if($isDup != 0): ?>
            <div class="message-box message-error">
                <i class="fas fa-exclamation-circle"></i> Insert Failed. Duplicate ID
            </div>
        <?php else: 
            $conn->query("INSERT INTO `service_table` SET service_id = '$serviceID', service_type = '$serviceName'");
        ?>
            <div class="message-box message-success">
                <i class="fas fa-check-circle"></i> Service Added Successfully
            </div>
        <?php endif; ?>
        
        <div class="form-actions">
            <a href="service-admin.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Services
            </a>
        </div>
    </div>
</body>
</html>