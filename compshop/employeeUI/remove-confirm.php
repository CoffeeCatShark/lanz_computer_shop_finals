<?php
include '../conn.php';

$id = $_POST['index'];

$sql = "DELETE FROM `active_table` WHERE `active_index`='$id'";

if ($conn->query($sql) === TRUE) {
    $message = "Record deleted successfully";
    $alertClass = "alert-success";
} else {
    $message = "Error deleting record: " . $conn->error;
    $alertClass = "alert-danger";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Deletion Confirmation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="<?php echo $alertClass ?>">
            <i class="fas fa-info-circle"></i> <?php echo $message ?>
        </div>
        <p>Redirecting back to active requests...</p>
    </div>
    
    <script>
        setTimeout(function() {
            window.location.href = 'activeDisplay.php';
        }, 3000);
    </script>
</body>
</html>