<?php
include '../conn.php';

$query = "SELECT * FROM service_table";
$serviceResult = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Display</title>
    <link rel="stylesheet" href="../ui/customerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="service-container animated fadeInUp">
        <h1>Lanz Computer Shop</h1>
        <h2>Available Services</h2>
        <p>Choose a service to reserve:</p>
        
        <div class="service-grid">
            <?php while($row = mysqli_fetch_assoc($serviceResult)): ?>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-<?php echo getServiceIcon($row['service_type']); ?>"></i>
                    </div>
                    <h3><?php echo htmlspecialchars($row['service_type']); ?></h3>
                    <p>Service ID: <?php echo htmlspecialchars($row['service_id']); ?></p>
                    <a href="request-service.php?id=<?php echo $row['service_index']; ?>" class="btn">
                        <i class="fas fa-calendar-plus"></i> Reserve
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php
    function getServiceIcon($serviceType) {
        $icons = [
            'cleaning' => 'broom',
            'repair' => 'tools',
            'maintenance' => 'wrench',
            'delivery' => 'truck',
            'consultation' => 'comments'
        ];
        
        $serviceLower = strtolower($serviceType);
        foreach ($icons as $key => $icon) {
            if (strpos($serviceLower, $key) !== false) {
                return $icon;
            }
        }
        return 'concierge-bell';
    }
    ?>
    
    <script src="../ui/customerScript.js"></script>
</body>
</html>