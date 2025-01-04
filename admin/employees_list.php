<?php
include('admin_navbar.php');
require '../includes/connection.php'; // Database connection file

// Start session
session_start();

// Check if the user is logged in as an admin
if (htmlspecialchars(!isset($_SESSION['loggedin'])) || htmlspecialchars($_SESSION['name']) !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

// Fetch employee data securely using PDO
try {
    $stmt = $pdo->prepare("SELECT ID, Name, Email, Role FROM employees ORDER BY Name ASC");
    $stmt->execute();
    $employees = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching employee data: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
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
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($employees as $row) {
                    $id = htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8');
                    $name = htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8');
                    $email = htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8');
                    $role = htmlspecialchars($row['Role'], ENT_QUOTES, 'UTF-8');

                    echo "<tr>
                            <td>{$id}</td>
                            <td>{$name}</td>
                            <td>{$email}</td>
                            <td>{$role}</td>
                            <td>
                             <div class='action-buttons'>
                             <button class='delete-btn' onclick='confirmDelete(" . $id . ")'>Delete</button>
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
        // JavaScript function to confirm deletion
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this employee?")) {
                window.location.href = `delete_employee.php?id=${encodeURIComponent(id)}`;
            }
        }


        // JavaScript function to edit employee details
    </script>
</body>

</html>