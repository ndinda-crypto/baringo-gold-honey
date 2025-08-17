<?php
// Show errors while testing
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'honey_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$fullName         = $_POST['full_name'] ?? null;
$idNumber         = $_POST['id_number'] ?? null;
$mobileNumber     = $_POST['mobile_number'] ?? null;
$email            = $_POST['email'] ?? null;
$county           = $_POST['county'] ?? null;
$postalCode       = $_POST['postal_code'] ?? null;
$deliveryLocation = $_POST['delivery_location'] ?? null;
$honeyAmount      = $_POST['honey_amount'] ?? null;

// Check required fields
if (!$fullName || !$idNumber || !$mobileNumber || !$email || !$county || !$deliveryLocation) {
    die("Error: Missing required fields.");
}

// Prepare insert
$sql = "INSERT INTO deliveries 
        (id_number, full_name, mobile_number, email, delivery_location, county, postal_code) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind and execute
$stmt->bind_param("isissss", $idNumber, $fullName, $mobileNumber, $email, $deliveryLocation, $county, $postalCode);

if ($stmt->execute()) {
    header("Location: payment.html");
    exit();
} else {
    die("Error executing query: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
