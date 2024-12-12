<?php
session_start();
require '../includes/connection.php'; // Database connection file

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

// Check if 'email' parameter is passed in the URL
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Prepare and execute the deletion query
    try {
        // Delete employee from the database
        $stmt = $conn->prepare("DELETE FROM employees WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Check if any rows were affected (employee deleted)
        if ($stmt->affected_rows > 0) {
            echo "Employee deleted successfully.";
        } else {
            echo "No employee found with the given email.";
        }

        $stmt->close();
    } catch (Exception $e) {
        die("Error deleting employee: " . $e->getMessage());
    }

    // Redirect back to the employee list page after deletion
    header("Location: employees_list.php");
    exit();
} else {
    // If 'email' parameter is not passed, redirect to the employee list page
    header("Location: employees_list.php");
    exit();
}
?>
