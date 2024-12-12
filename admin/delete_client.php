<?php
// Start the session to check if the user is logged in
session_start();

// Include the database connection file
require '../includes/connection.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'admin123') {
    // Redirect to login page if not logged in as an admin
    header("Location: ../login.php");
    exit();
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $clientId = $_GET['id'];

    // Validate the ID (ensure it's a number to prevent SQL injection)
    if (!is_numeric($clientId)) {
        echo "Invalid client ID.";
        exit();
    }

    // Prepare the DELETE SQL query using a prepared statement
    $stmt = $conn->prepare("DELETE FROM guest WHERE ID = ?");
    $stmt->bind_param("i", $clientId);  // "i" stands for integer type
    
    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Redirect to the client list page after successful deletion
        header("Location: client_sec.php?message=Client deleted successfully");
    } else {
        echo "Error deleting client: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "No client ID provided.";
}
?>
