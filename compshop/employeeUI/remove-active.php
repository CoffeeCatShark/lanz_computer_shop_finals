<?php
include '../conn.php';
$query = "select * from `active_table`";

$query_ = "SELECT *
FROM request_table
JOIN active_table ON request_table.request_id = active_table.request_id;";

$activeResult = mysqli_query($conn, $query);
$fetchResult = mysqli_query($conn,$query_);

$index = $_GET['id'];
$activeIndex = $_GET['id2'];
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
    <title>Remove Active Request</title>
    <link rel="stylesheet" href="../ui/employeeStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <form action="remove-confirm.php" method="post">
            <h2><i class="fas fa-exclamation-triangle"></i> Remove Request Confirmation</h2>
            
            <table>
                <tr>
                    <td><label>ID:</label></td>
                    <td>
                        <input readonly type="text" name="id" value="<?php echo htmlspecialchars($id) ?>">
                    </td>
                </tr>
                
                <tr>
                    <td><label>Type:</label></td>
                    <td>
                        <input readonly type="text" name="serviceID" value="<?php echo htmlspecialchars($type) ?>">
                    </td>
                </tr>
                
                <tr>
                    <td><label>Customer Name:</label></td>
                    <td>
                        <input readonly type="text" name="price" value="<?php echo htmlspecialchars($fllname) ?>">
                        <input type="hidden" value='<?php echo htmlspecialchars($id) ?>' name="index">
                    </td>
                </tr>
                
                <tr>
                    <td><label>Time:</label></td>
                    <td>
                        <input readonly type="text" name="time" value="<?php echo htmlspecialchars($time) ?>">
                    </td>
                </tr>
                
                <tr>
                    <td><label>File:</label></td>
                    <td>
                        <?php if($file != "../docs/"): ?>
                            <a href="<?php echo htmlspecialchars($file) ?>" class="file-link">
                                <i class="fas fa-file-download"></i> Download
                            </a>
                        <?php else: ?>
                            <span class="no-file">No file</span>
                        <?php endif; ?>
                        <input type="hidden" value='<?php echo htmlspecialchars($activeIndex) ?>' name="index">
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="Confirm Delete" class="btn btn-danger">
                        <button type="button" class="btn btn-warning" onClick="window.location.href='activeDisplay.php'">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    
    <script src="../ui/employeeScript.js"></script>
</body>
</html>