<?php
$conn = new mysqli('localhost', 'root', '', 'computer_shop');

// Create first admin
$username = 'initial_admin';
$email = 'admin@company.com';
$password = 'TempPass123!';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$conn->query("INSERT INTO users (username, email, password, role) 
    VALUES ('$username', '$email', '$hashedPassword', 'admin')");

echo "First admin created! Username: $username, Password: $password";
?>