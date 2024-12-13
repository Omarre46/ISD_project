<?php
require("../includes/connection.php");

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // Prepare the delete query
    $deleteStmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
    $deleteStmt->bind_param("i", $deleteId);
    
    if ($deleteStmt->execute()) {
        // Deletion was successful, redirect back to feedback list
        header("Location: feedback.php?message=deleted");
        exit();
    } else {
        // Error during deletion
        echo "Error: Could not delete feedback.";
    }
    $deleteStmt->close();
} else {
    echo "No feedback ID provided.";
}

?>
