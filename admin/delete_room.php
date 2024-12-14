<?php
// Include the necessary files and start the session
require '../includes/connection.php'; // Include database connection
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

// Check if the 'id' parameter is passed in the URL
if (isset($_GET['id'])) {
    $roomId = $_GET['id'];

    // Fetch the room details to get the image file path
    $stmt = $conn->prepare("SELECT RoomImage FROM rooms WHERE ID = ?");
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Room found, fetch room image name
        $row = $result->fetch_assoc();
        $roomImage = $row['RoomImage'];

        // If there's an image, delete it from the server
        if ($roomImage && file_exists("room_imgs/" . $roomImage)) {
            unlink("room_imgs/" . $roomImage); // Delete the image file
        }

        // Now delete the room record from the database
        $stmt = $conn->prepare("DELETE FROM rooms WHERE ID = ?");
        $stmt->bind_param("i", $roomId);

        if ($stmt->execute()) {
            // Redirect to the room list page after successful deletion
            header("Location: list_room.php?status=deleted");
            exit();
        } else {
            // Error deleting room
            echo "Error deleting room from the database.";
        }
    } else {
        echo "Room not found.";
    }
} else {
    echo "Invalid request.";
}
?>
