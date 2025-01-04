<?php
include("admin_navbar.php");
require '../includes/connection.php'; // Include database connection

// Start session to check if the user is logged in
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || htmlspecialchars($_SESSION['name']) !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = htmlspecialchars($_POST['role']);

    try {
        // Check if the email already exists in the guests table using PDO
        $emailCheckQuery = "SELECT * FROM guest WHERE Email = :email";
        $emailCheckStmt = $pdo->prepare($emailCheckQuery);
        $emailCheckStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $emailCheckStmt->execute();

        if ($emailCheckStmt->rowCount() > 0) {
            $errorMessage = "This email is already associated with a guest and cannot be used.";
        } else {
            // Insert the new employee into the database using PDO
            $query = "INSERT INTO employees (Name, Email, Password, Role) VALUES (:name, :email, :password, :role)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $successMessage = "Employee added successfully.";
            } else {
                $errorMessage = "Error adding employee: " . $stmt->errorInfo()[2];
            }
        }
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employees</title>
    <link rel="stylesheet" href="style/add_employee.css"> <!-- Your CSS for styling -->
</head>

<body>
    <h2>Add New Employee</h2>

    <?php
    if (isset($successMessage)) {
        echo "<p class='success'>$successMessage</p>";
    }
    if (isset($errorMessage)) {
        echo "<p class='error'>$errorMessage</p>";
    }
    ?>

    <form method="POST" action="">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
        <label for="role">Service Type</label>
                <select id="role" name="role" required>
                    <option value="">Select a Role</option>
                    <option value="housekeeping">Housekeeping Staff</option>
                    <option value="waiter">Waiter</option>
                    <option value="maintenance">Maintenance Technician</option>
                </select>
        </div>

        <div>
            <button type="submit">Add Employee</button>
        </div>
    </form>

    <script>
        // Optional: Add any necessary JavaScript for form validation or interactivity
    </script>
</body>

</html>
