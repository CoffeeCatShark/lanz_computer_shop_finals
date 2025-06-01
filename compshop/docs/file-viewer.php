<?php
include '../conn.php';

if(isset($_GET['file'])) {
    $filePath = urldecode($_GET['file']);
    
    // Security check - verify the file is in the allowed directory
    $allowedPath = realpath('../docs/');
    $requestedFile = realpath($filePath);
    
    if(strpos($requestedFile, $allowedPath) === 0 && file_exists($requestedFile)) {
        $fileName = basename($requestedFile);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>File Viewer</title>
            <link rel="stylesheet" href="../ui/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body>
            <div class="file-viewer-container">
                <div class="file-header">
                    <h1><i class="fas fa-file"></i> <?= htmlspecialchars($fileName) ?></h1>
                </div>
                
                <div class="file-preview">
                    <?php
                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    if(in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                        echo '<img src="'.htmlspecialchars($filePath).'" alt="File Preview" style="max-width: 100%;">';
                    } elseif($fileExt === 'pdf') {
                        echo '<embed src="'.htmlspecialchars($filePath).'" type="application/pdf" width="100%" height="600px">';
                    } else {
                        echo '<p>Preview not available for this file type.</p>';
                    }
                    ?>
                </div>
                
                <div class="file-actions">
                    <a href="<?= htmlspecialchars($filePath) ?>" download class="download-btn">
                        <i class="fas fa-download"></i> Download File
                    </a>
                    <button onclick="window.history.back()" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
            
            <script src="../ui/script.js"></script>
        </body>
        </html>
        <?php
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "File not found or access denied.";
    }
} else {
    header("Location: ../Prototype_access_control/admin_dashboard.php");
}
?>