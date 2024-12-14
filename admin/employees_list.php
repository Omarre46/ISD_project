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

// Fetch employee data securely using prepared statements
try {
    $stmt = $conn->prepare("SELECT ID, Name, Email, Role FROM employees ORDER BY Name ASC");
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    die("Error fetching employee data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Employee List</title>
    <link rel="stylesheet" href="style/list_employee.css">
</head>

<body>
    <center>
        <h2>Employee List</h2>
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th> <!-- Added Employee ID column -->
                    <th>Employee Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    $id = htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8'); // Employee ID
                    $name = htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8');
                    $email = htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8');
                    $role = htmlspecialchars($row['Role'], ENT_QUOTES, 'UTF-8');

                    echo "<tr>
                            <td>{$id}</td> <!-- Display Employee ID -->
                            <td>{$name}</td>
                            <td>{$email}</td>
                            <td>{$role}</td>
                            <td>
                                <div class='action-buttons'>
                                   <button class='delete-btn' onclick='confirmDelete(\"{$email}\")'>Delete</button>
                                </div>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </center>

    <script>
        // JavaScript function to confirm deletion
        function confirmDelete(email) {
            if (confirm("Are you sure you want to delete this employee?")) {
                window.location.href = `delete_employee.php?email=${encodeURIComponent(email)}`;
            }
        }

        // JavaScript function to edit employee details
    </script>
</body>

</html>
