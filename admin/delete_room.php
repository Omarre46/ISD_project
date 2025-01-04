<?php
require '../includes/connection.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $roomId = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

    if (!is_numeric($roomId)) {
        echo "Invalid room ID.";
        exit();
    }

    try {
        $pdo->beginTransaction();

        // Fetch room image path
        $stmt = $pdo->prepare("SELECT RoomImage FROM rooms WHERE ID = :id");
        $stmt->bindParam(':id', $roomId, PDO::PARAM_INT);
        $stmt->execute();

        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($room) {
            $roomImage = $room['RoomImage'];
            if ($roomImage && file_exists("room_imgs/" . $roomImage)) {
                unlink("room_imgs/" . $roomImage);
            }

            // Delete the room record
            $deleteStmt = $pdo->prepare("DELETE FROM rooms WHERE ID = :id");
            $deleteStmt->bindParam(':id', $roomId, PDO::PARAM_INT);
            $deleteStmt->execute();

            $pdo->commit();
            header("Location: list_room.php?status=deleted");
            exit();
        } else {
            echo "Room not found.";
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Error deleting room: " . htmlspecialchars($e->getMessage()));
    }
} else {
    echo "Invalid request.";
}
?>
