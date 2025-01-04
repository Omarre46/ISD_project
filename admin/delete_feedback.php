<?php
session_start();
require '../includes/connection.php'; // Database connection file

// Check if the user is logged in as an admin
if (htmlspecialchars(!isset($_SESSION['loggedin'])) || htmlspecialchars($_SESSION['name']) !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

// Check if 'delete_id' parameter is passed in the URL
if (htmlspecialchars(isset($_GET['delete_id']))) {
    $deleteId = htmlspecialchars($_GET['delete_id'], ENT_QUOTES, 'UTF-8');

    // Validate delete_id (ensure it's numeric)
    if (!is_numeric($deleteId)) {
        die("Invalid feedback ID.");
    }

    try {
        // Use PDO to prepare and execute the deletion query
        $stmt = $pdo->prepare("DELETE FROM feedback WHERE id = :id");
        $stmt->bindParam(':id', $deleteId, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            // Redirect with a success message
            header("Location: feedback.php?message=Feedback deleted successfully");
            exit();
        } else {
            // Redirect with an error message
            header("Location: feedback.php?message=No feedback found with the given ID");
            exit();
        }
    } catch (PDOException $e) {
        die("Error deleting feedback: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
    }
} else {
    // Redirect to the feedback list page if 'delete_id' parameter is missing
    header("Location: feedback.php?message=No ID provided");
    exit();
}
?>
