<?php
require_once '../Prototype_access_control/auth_check.php';
require_once '../conn.php';

// Verify that the user is an admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: unauthorized.php");
    exit();
}

$message = '';
$employees = [];

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    
    // First get the user's role to prevent deleting admins
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Prevent deleting admin accounts
        if ($user['role'] === 'admin') {
            $message = '<div class="alert alert-danger">Cannot delete admin accounts!</div>';
        } 
        // Prevent deleting your own account
        else if ($delete_id == $_SESSION['user_id']) {
            $message = '<div class="alert alert-danger">You cannot delete your own account!</div>';
        } 
        // Proceed with deletion
        else {
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $delete_id);
            
            if ($stmt->execute()) {
                $message = '<div class="alert alert-success">Employee deleted successfully!</div>';
            } else {
                $message = '<div class="alert alert-danger">Error deleting employee: ' . $conn->error . '</div>';
            }
        }
    } else {
        $message = '<div class="alert alert-danger">User not found!</div>';
    }
}

// Fetch all employees (non-admin users)
$sql = "SELECT id, username, email, role, created_at FROM users WHERE role = 'employee' ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $employees = $result->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Employee</title>
    <link rel="stylesheet" href="../ui/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <div class="container fade-in">
        <h1><i class="fas fa-user-times"></i> Delete Employee</h1>
        
        <?php echo $message; ?>
        
        <?php if (empty($employees)): ?>
            <p>No employee accounts found.</p>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee): ?>
                        <tr class="fade-in">
                            <td><?php echo htmlspecialchars($employee['id']); ?></td>
                            <td><?php echo htmlspecialchars($employee['username']); ?></td>
                            <td><?php echo htmlspecialchars($employee['email']); ?></td>
                            <td><?php echo htmlspecialchars($employee['created_at']); ?></td>
                            <td>
                                <button class="btn btn-delete" 
                                        onclick="confirmDelete(<?php echo $employee['id']; ?>, '<?php echo htmlspecialchars($employee['username']); ?>')">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <div class="action-buttons">
            <a href="../Prototype_access_control/admin_dashboard.php" target="_parent" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <script>
        function confirmDelete(id, username) {
            if (confirm(`Are you sure you want to delete employee "${username}" (ID: ${id})? This action cannot be undone.`)) {
                window.location.href = `delete_employee.php?delete_id=${id}`;
            }
        }
    </script>
</body>
</html>