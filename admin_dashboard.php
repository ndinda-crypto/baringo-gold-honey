<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

$servername = "localhost";
$username = "root"; // default for XAMPP
$password = "";
$dbname = "honey_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        header {
            background: #ffcc00;
            padding: 15px;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        .logout {
            position: absolute;
            right: 20px;
            top: 15px;
            background: #e60000;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout:hover {
            background: #cc0000;
        }
        h2 {
            margin-top: 30px;
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 95%;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #ffcc00;
        }
        tr:hover {
            background: #f1f1f1;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h1>
    <a class="logout" href="logout.php">Logout</a>
</header>

<!-- Deliveries Table -->
<h2>All Delivery Requests</h2>
<table>
    <tr>
        <th>ID Number</th>
        <th>Full Name</th>
        <th>Mobile Number</th>
        <th>Email</th>
        <th>Delivery Location</th>
        <th>County</th>
        <th>Postal Code</th>
        <th>Date</th>
    </tr>
    <?php
    $sql = "SELECT id_number, full_name, mobile_number, email, delivery_location, county, postal_code, created_at FROM deliveries ORDER BY id_number DESC";
    $result = $conn->query($sql);

    if (!$result) {
        echo "<tr><td colspan='8'>Error: " . $conn->error . "</td></tr>";
    } elseif ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id_number']}</td>
                    <td>{$row['full_name']}</td>
                    <td>{$row['mobile_number']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['delivery_location']}</td>
                    <td>{$row['county']}</td>
                    <td>{$row['postal_code']}</td>
                    <td>{$row['created_at']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No deliveries found.</td></tr>";
    }
    ?>
</table>

<!-- Users Table -->
<h2>All Users Who Interacted with the System</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Role</th>
        <th>Date Joined</th>
    </tr>
    <?php
    $sql = "SELECT id, name, email, phone_number, role, created_at FROM users ORDER BY id DESC";
    $result = $conn->query($sql);

    if (!$result) {
        echo "<tr><td colspan='6'>Error: " . $conn->error . "</td></tr>";
    } elseif ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone_number']}</td>
                    <td>{$row['role']}</td>
                    <td>{$row['created_at']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No users found.</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
