<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// For admin-only pages
if ($_SESSION['role'] !== 'admin') {
    header("Location: unauthorized.php");
    exit();
}
?>