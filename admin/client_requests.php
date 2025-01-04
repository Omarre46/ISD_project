<?php
include('admin_navbar.php');
require '../includes/connection.php'; // Database connection file

// Start session
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

// Fetch service data securely using prepared statements
try {
    $stmt = $pdo->prepare("
        SELECT 
            service.ID, 
            service.Name AS guest_name, 
            service.Type, 
            service.Guest_ID, 
            service.Employee_ID, 
            service.Status, 
            guest.Email, 
            employees.Name AS employee_name
        FROM service
        LEFT JOIN guest ON service.Guest_ID = guest.ID
        LEFT JOIN employees ON service.Employee_ID = employees.ID
        ORDER BY service.ID DESC
    ");
    $stmt->execute();
    $services = $stmt->fetchAll(); // Fetch all rows as an associative array
} catch (PDOException $e) {
    die("Error fetching service data: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Service List</title>
    <link rel="stylesheet" href="./style/client_service.css">
</head>

<body>
    <center>
        <h2>Service Requests</h2>
        <table>
            <thead>
                <tr>
                    <th>Service ID</th>
                    <th>Guest Name</th>
                    <th>Service Type</th>
                    <th>Employee Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($services as $row) {
                    $service_id = htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8');
                    $guest_name = htmlspecialchars($row['guest_name'], ENT_QUOTES, 'UTF-8');
                    $service_type = htmlspecialchars($row['Type'], ENT_QUOTES, 'UTF-8');
                    $employee_name = htmlspecialchars($row['employee_name'], ENT_QUOTES, 'UTF-8');
                    $status = htmlspecialchars($row['Status'], ENT_QUOTES, 'UTF-8');
                    $guest_email = htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8');

                    echo "<tr>
            <td>{$service_id}</td>
            <td>{$guest_name}</td>
            <td>{$service_type}</td>
            <td>{$employee_name}</td>
            <td>{$status}</td>
            <td>
                <button class='delete-btn' onclick='confirmDelete({$service_id})'>Delete</button>
            </td>
          </tr>";
                }
                ?>

            </tbody>
        </table>
    </center>

    <script>
        // JavaScript function to confirm deletion
        function confirmDelete(service_id) {
            if (confirm("Are you sure you want to delete this service?")) {
                window.location.href = `delete_service.php?service_id=${encodeURIComponent(service_id)}`;
            }
        }
    </script>
</body>

</html>