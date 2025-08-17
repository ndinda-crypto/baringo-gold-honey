<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$host = "localhost";
$user = "root"; // XAMPP default username
$pass = "";     // XAMPP default password is empty
$dbname = "honey_system";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Get form inputs safely
$name = $_POST['loginName'] ?? '';
$email = $_POST['loginEmail'] ?? '';
$phone_number = $_POST['loginPhoneNumber'] ?? '';

// Validate inputs
if (empty($name) || empty($email) || empty($phone_number)) {
    die("Missing required fields: " . json_encode($_POST));
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO users (name, email, phone_number) VALUES (?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $name, $email, $phone_number);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Insert failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
