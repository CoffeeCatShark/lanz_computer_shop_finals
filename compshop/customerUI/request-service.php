<?php
include '../conn.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid service ID.");
}

$index = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT service_type FROM service_table WHERE service_index = ?");
$stmt->bind_param("i", $index);
$stmt->execute();
$stmt->bind_result($type);
$stmt->fetch();
$stmt->close();

if (empty($type)) {
    die("Service not found.");
}

// Get reserved times
$reserved_times = [];
$sql = "SELECT timestamp FROM request_table INNER JOIN active_table ON request_table.request_id = active_table.request_id";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $reserved_times[] = $row['timestamp'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Service</title>
    <link rel="stylesheet" href="../ui/customerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="reservation-container animated fadeInUp">
        <h1>Reserve <?php echo htmlspecialchars($type); ?> Service</h1>
        
        <form method="POST" action="request-confirm.php" enctype="multipart/form-data">
            <input type="hidden" name="index" value="<?php echo htmlspecialchars($index); ?>">
            
            <label for="fllname"><i class="fas fa-user"></i> Full Name</label>
            <input type="text" id="fllname" name="fllname" required 
                   placeholder="Enter your full name"
                   pattern="[A-Za-z\s]{2,50}" 
                   title="Only letters and spaces allowed (2-50 characters)">
            
            <label for="date"><i class="fas fa-calendar-day"></i> Select Date</label>
            <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
            
            <label><i class="fas fa-clock"></i> Select Time Slot</label>
            <div class="time-slots">
                <?php
                $times = [
                    '12:00' => '12:00 PM',
                    '12:30' => '12:30 PM',
                    '13:00' => '1:00 PM',
                    '13:30' => '1:30 PM',
                    '14:00' => '2:00 PM',
                    '14:30' => '2:30 PM',
                    '15:00' => '3:00 PM',
                    '15:30' => '3:30 PM',
                    '16:00' => '4:00 PM',
                    '16:30' => '4:30 PM',
                    '17:00' => '5:00 PM',
                    '17:30' => '5:30 PM',
                    '18:00' => '6:00 PM'
                ];
                
                foreach ($times as $value => $label): 
                    $isReserved = false;
                    foreach ($reserved_times as $reserved) {
                        $reservedTime = date('H:i', strtotime($reserved));
                        if ($reservedTime == $value) {
                            $isReserved = true;
                            break;
                        }
                    }
                ?>
                    <label class="time-slot">
                        <input type="radio" name="time" value="<?php echo $value; ?>" required>
                        <span><?php echo $label; ?></span>
                        
                    </label>
                <?php endforeach; ?>
            </div>
            <small>Available Time Slots: 12:00 PM - 6:00 PM</small>
            
            <label for="service_type"><i class="fas fa-concierge-bell"></i> Service Type</label>
            <input type="text" id="service_type" name="service_type" 
                   value="<?php echo htmlspecialchars($type); ?>" readonly>
            
            <label for="file"><i class="fas fa-image"></i> Upload Image (Optional)</label>
            <input type="file" id="file" name="file" accept="image/*,.pdf,.doc,.docx">
            
            <button type="submit" class="btn">
                <i class="fas fa-check-circle"></i> Confirm Reservation
            </button>
            
            <a href="customer-ui.php" class="btn btn-secondary">
                <i class="fas fa-times-circle"></i> Cancel
            </a>
        </form>
    </div>
    
    <script src="../ui/customerScript.js"></script>
</body>
</html>