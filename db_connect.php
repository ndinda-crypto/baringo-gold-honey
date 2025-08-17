<?php
$host = "localhost";      // Server name
$user = "root";           // MySQL username (default in XAMPP)
$pass = "";               // MySQL password (leave empty in XAMPP by default)
$dbname = "honey_system"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
