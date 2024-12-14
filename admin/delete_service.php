<?php
require '../includes/connection.php';
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

// Check if service_id is provided
if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    // Delete service record using prepared statement
    try {
        $stmt = $conn->prepare("DELETE FROM service WHERE ID = ?");
        $stmt->bind_param("i", $service_id);
        $stmt->execute();

        // Redirect to service list page after successful deletion
        header("Location: client_requests.php");  // Assuming this page shows the service list
        exit();
    } catch (Exception $e) {
        die("Error deleting service: " . $e->getMessage());
    }
} else {
    // Redirect to the service list page if no service_id is passed
    header("Location: client_requests.php");
    exit();
}
?>
