<!DOCTYPE html>
<html>
<head>
    <title>Add New Service</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="confirmation-container">
        <div class="confirmation-header">
            <h2><i class="fas fa-plus-circle"></i> Add New Service</h2>
        </div>
        
        <form class="confirmation-form" method="POST" action="confirm-service.php">
            <div class="form-row">
                <label>Service Description:</label>
                <input type="text" required name="service_name">
            </div>
            
            <div class="form-row">
                <label>Service ID:</label>
                <input type="text" required name="service_id">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Add Service
                </button>
                <a href="service-admin.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>