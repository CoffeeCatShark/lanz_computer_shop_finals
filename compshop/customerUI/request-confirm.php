<?php
include '../conn.php';
$target_dir = "../docs/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// File type validation
$allowedTypes = ["jpg", "png", "jpeg", "gif", "pdf", "doc", "docx"];
if (!empty($_FILES["file"]["name"]) && !in_array($imageFileType, $allowedTypes)) {
    $uploadError = "Sorry, only JPG, PNG, GIF, PDF, DOC & DOCX files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 1 && !empty($_FILES["file"]["name"])) {
    if (!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $uploadError = "Sorry, there was an error uploading your file.";
    }
}

// Process form data
$index = $_POST['index'];
$name = $_POST['fllname'];
$date = $_POST['date'];
$time = $_POST['time'];

$datetime = "$date $time";
$type = $_POST['service_type'];
$filename = $_FILES["file"]["name"];
$id = 0;

// Get service type details
$sql = "SELECT * FROM service_table WHERE service_index = '$index'";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $type = $row['service_type'];    
}

// Get next request ID
$sql = "SELECT MAX(request_index) as max_id FROM request_table";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row['max_id'] + 1;
} else {
    $id = 1;
}

// Check availability
$query_ = "SELECT *
    FROM `request_table`
    JOIN `active_table` ON `request_table`.`request_id` = `active_table`.`request_id`
    WHERE `request_table`.`timestamp` = '$datetime'";
$isAvail = 0;
$result = $conn->query($query_);
if($result->num_rows > 0) {
    $isAvail = $result->num_rows;
}

// Process reservation
if($isAvail != 0) {
    $message = "Timeslot has been booked. Please choose another time from the list!";
    $isError = true;
} else {
    $conn->query("INSERT INTO `request_table` SET `request_id` = '$id', `customer_name` = '$name',
        `timestamp` = '$datetime', `service_type` = '$type', `file_upload` = '$target_file'");
    $conn->query("INSERT INTO `active_table` SET `request_id` = '$id'");
    $message = "Your reservation has been confirmed. Please arrive at the scheduled time!";
    $isError = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Confirmation</title>
    <link rel="stylesheet" href="../ui/customerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="confirmation-container animated fadeInUp">
        <div class="confirmation-icon <?php echo $isError ? 'error-icon' : 'success-icon'; ?>">
            <i class="fas <?php echo $isError ? 'fa-times-circle' : 'fa-check-circle'; ?>"></i>
        </div>
        <h2><?php echo $isError ? 'Reservation Failed' : 'Reservation Confirmed!'; ?></h2>
        <p><?php echo $message; ?></p>
        
        <?php if(!$isError): ?>
        <div class="confirmation-details">
            <div class="detail-row">
                <span class="detail-label">Service Type:</span>
                <span><?php echo htmlspecialchars($type); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Customer Name:</span>
                <span><?php echo htmlspecialchars($name); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date & Time:</span>
                <span><?php echo date('F j, Y g:i A', strtotime($datetime)); ?></span>
            </div>
            <?php if(!empty($filename)): ?>
            <div class="detail-row">
                <span class="detail-label">File Uploaded:</span>
                <span><?php echo htmlspecialchars($filename); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="confirmation-actions">
            <?php if($isError): ?>
                <a href="request-service.php?id=<?php echo $index; ?>" class="btn">
                    <i class="fas fa-arrow-left"></i> Try Again
                </a>
            <?php endif; ?>
            <a href="customer-ui.php" class="btn <?php echo $isError ? 'btn-secondary' : ''; ?>">
                <i class="fas fa-home"></i> Back to Services
            </a>
        </div>
    </div>
    
    <script src="../ui/customerScript.js"></script>
</body>
</html>