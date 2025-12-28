<?php
// Database connection. Prefer setting credentials via environment variables in production.
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$db   = getenv('DB_NAME') ?: 'drjadhav_sample';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    // Log the detailed error but don't reveal it to users
    error_log('Database connection failed: ' . mysqli_connect_error());
    // Generic message for users
    die('Database connection failed. Please contact the administrator.');
}

// Use utf8mb4 charset to support full Unicode
mysqli_set_charset($conn, 'utf8mb4');
?>
