<?php
session_start();
require '../includes/connection.php'; // Database connection file

// Check if the user is logged in as an admin
if (htmlspecialchars(!isset($_SESSION['loggedin'])) || htmlspecialchars($_SESSION['name']) !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

// Check if 'id' parameter is passed in the URL
if (htmlspecialchars(isset($_GET['id']))) {
    $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

    // Validate ID (ensure it's numeric)
    if (!is_numeric($id)) {
        die("Invalid employee ID.");
    }

    try {
        // Use PDO to prepare and execute the deletion query
        $stmt = $pdo->prepare("DELETE FROM employees WHERE ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            // Redirect with a success message
            header("Location: employees_list.php?message=Employee deleted successfully");
            exit();
        } else {
            // Redirect with an error message
            header("Location: employees_list.php?message=No employee found with the given ID");
            exit();
        }
    } catch (PDOException $e) {
        die("Error deleting employee: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
    }
} else {
    // Redirect to the employee list page if 'id' parameter is missing
    header("Location: employees_list.php?message=No ID provided");
    exit();
}
?>
