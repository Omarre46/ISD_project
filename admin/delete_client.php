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
    $clientId = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

    // Validate the ID (ensure it's a numeric value)
    if (!is_numeric($clientId)) {
        echo "Invalid client ID.";
        exit();
    }

    try {
        // Prepare the DELETE SQL query using a prepared statement
        $stmt = $pdo->prepare("DELETE FROM guest WHERE ID = :id");
        $stmt->bindParam(':id', $clientId, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the client list page after successful deletion
            header("Location: client_sec.php?message=Client deleted successfully");
            exit();
        } else {
            echo "Error deleting client.";
        }
    } catch (PDOException $e) {
        echo "Error deleting client: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "No client ID provided.";
}
?>
