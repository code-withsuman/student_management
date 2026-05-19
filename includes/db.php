<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'school_db');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die('<div style="font-family:sans-serif;padding:40px;text-align:center;">
        <h2 style="color:#e74c3c;">⚠ Database Connection Failed</h2>
        <p>' . mysqli_connect_error() . '</p>
        <p>Make sure XAMPP is running and the database <strong>school_db</strong> exists.<br>
        Import <code>database/school_db.sql</code> in phpMyAdmin.</p>
    </div>');
}

mysqli_set_charset($conn, 'utf8mb4');
?>
