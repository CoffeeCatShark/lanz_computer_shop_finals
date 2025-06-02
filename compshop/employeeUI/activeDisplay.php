<?php
include '../conn.php';

$query = "select * from `active_table`";

$query_ = "SELECT *
FROM request_table
JOIN active_table ON request_table.request_id = active_table.request_id
ORDER BY request_table.timestamp";

$activeResult = mysqli_query($conn, $query);
$fetchResult = mysqli_query($conn,$query_);

// Check if we're viewing a file
$viewingFile = isset($_GET['view']) && $_GET['view'] == 'file';
$fileToView = isset($_GET['file']) ? $_GET['file'] : '';

if ($viewingFile && !empty($fileToView)) {
    // Extract filename from path
    $filename = basename($fileToView);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>View File</title>
        <link rel="stylesheet" href="../ui/employeeStyle.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <h1>Viewing File: <?php echo htmlspecialchars($filename) ?></h1>
            <div class="file-viewer">
                <?php if (file_exists($fileToView)): ?>
                    <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $fileToView)): ?>
                        <img src="<?php echo htmlspecialchars($fileToView) ?>" alt="Uploaded Image" style="max-width: 100%; max-height: 500px;">
                    <?php elseif (preg_match('/\.(pdf)$/i', $fileToView)): ?>
                        <embed src="<?php echo htmlspecialchars($fileToView) ?>" type="application/pdf" width="100%" height="600px">
                    <?php else: ?>
                        <p>This file type cannot be previewed. Please download it to view.</p>
                    <?php endif; ?>
                    
                    <div class="file-actions">
                        <a href="<?php echo htmlspecialchars($fileToView) ?>" download class="btn btn-download">
                            <i class="fas fa-file-download"></i> Download File
                        </a>
                        <a href="activeDisplay.php" class="btn btn-back">
                            <i class="fas fa-arrow-left"></i> Back to Requests
                        </a>
                    </div>
                <?php else: ?>
                    <p>File not found.</p>
                    <a href="activeDisplay.php" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Requests
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Active Requests Display</title>
    <link rel="stylesheet" href="../ui/employeeStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>Active Service Requests</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Service Type</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>File Upload</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($fetchResult)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['service_type']) ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']) ?></td>
                        <td><?= date("M j, Y", strtotime($row['timestamp'])) ?></td>
                        <td><?php echo date("g:i A", strtotime($row['timestamp'])) ?></td>
                        <td>
                            <?php if($row['file_upload'] != "../docs/"): ?>
                                
                                <div class="file-upload-actions">
                                    <a href="activeDisplay.php?view=file&file=<?php echo urlencode($row['file_upload']) ?>">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                   
                                </div>
                            <?php else: ?>
                                <span class="no-file">No file</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="remove-active.php?id=<?php echo $row['request_index'] ?>&id2=<?php echo $row['active_index'] ?>" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
            </tbody>
        </table>
        
        
    </div>
    
    <script src="../ui/employeeScript.js"></script>
</body>
</html>