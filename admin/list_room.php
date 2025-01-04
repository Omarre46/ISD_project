<?php
include("admin_navbar.php");
require '../includes/connection.php'; // Include database connection

// Start session to check if the user is logged in
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

try {
    // Fetch room data using PDO
    $stmt = $pdo->prepare("SELECT ID, RoomName, RoomNumber, RoomCategory, Description, RoomPrice, RoomImage FROM rooms");
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching room data: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room List</title>
    <link rel="stylesheet" href="style/list_room.css"> <!-- Your original room list CSS -->
</head>

<body>
    <h2>Room List</h2>
    <table>
        <thead>
            <tr>
                <th>Room ID</th>
                <th>Room Name</th> <!-- Column for Room Name -->
                <th>Room Number</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rooms)): ?>
                <?php foreach ($rooms as $room): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($room['ID'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($room['RoomName'], ENT_QUOTES, 'UTF-8'); ?></td> <!-- Display Room Name -->
                        <td><?php echo htmlspecialchars($room['RoomNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($room['RoomCategory'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($room['Description'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>$<?php echo htmlspecialchars($room['RoomPrice'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <div class="action-buttons">
                                <!-- View Button -->
                                <button class="view-btn" onclick="showRoomDetails(
                                    '<?php echo htmlspecialchars($room['RoomName'], ENT_QUOTES, 'UTF-8'); ?>',
                                    '<?php echo htmlspecialchars($room['RoomNumber'], ENT_QUOTES, 'UTF-8'); ?>',
                                    '<?php echo htmlspecialchars($room['RoomCategory'], ENT_QUOTES, 'UTF-8'); ?>',
                                    '<?php echo htmlspecialchars($room['Description'], ENT_QUOTES, 'UTF-8'); ?>',
                                    '<?php echo htmlspecialchars($room['RoomPrice'], ENT_QUOTES, 'UTF-8'); ?>',
                                    '<?php echo htmlspecialchars($room['RoomImage'], ENT_QUOTES, 'UTF-8'); ?>'
                                )">View</button>

                                <!-- Update Button -->
                                <a href="modify_room.php?id=<?php echo $room['ID']; ?>&roomNumber=<?php echo urlencode($room['RoomNumber']); ?>&roomName=<?php echo urlencode($room['RoomName']); ?>&roomCategory=<?php echo urlencode($room['RoomCategory']); ?>&roomDescription=<?php echo urlencode($room['Description']); ?>&roomPrice=<?php echo urlencode($room['RoomPrice']); ?>&roomImage=<?php echo urlencode($room['RoomImage']); ?>" class="update-btn">Update</a>

                                <!-- Delete Button -->
                                <a href="delete_room.php?id=<?php echo htmlspecialchars($room['ID'], ENT_QUOTES, 'UTF-8'); ?>"
                                   class="delete-btn"
                                   onclick="return confirm('Are you sure you want to delete this room?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7">No rooms found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Modal Popup for Room Details -->
    <div id="roomModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h3>Room Details</h3>
            <p><strong>Room Name:</strong> <span id="roomName"></span></p>
            <p><strong>Room Number:</strong> <span id="roomNumber"></span></p>
            <p><strong>Room Category:</strong> <span id="roomCategory"></span></p>
            <p><strong>Description:</strong> <span id="roomDescription"></span></p>
            <p><strong>Price:</strong> $<span id="roomPrice"></span></p>
            <p><strong>Room Image:</strong></p>
            <img id="roomImage" src="" alt="Room Image" style="width: 100%; max-width: 400px; height: auto;">
        </div>
    </div>

    <script>
        // Function to show the room details in the modal, including the image
        function showRoomDetails(roomName, roomNumber, roomCategory, roomDescription, roomPrice, roomImage) {
            document.getElementById('roomName').textContent = roomName;
            document.getElementById('roomNumber').textContent = roomNumber;
            document.getElementById('roomCategory').textContent = roomCategory;
            document.getElementById('roomDescription').textContent = roomDescription;
            document.getElementById('roomPrice').textContent = roomPrice;
            document.getElementById('roomImage').src = roomImage;

            document.getElementById('roomModal').style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('roomModal').style.display = "none";
        }

        // Close the modal when the user clicks outside the modal content
        window.onclick = function(event) {
            if (event.target == document.getElementById('roomModal')) {
                closeModal();
            }
        }
    </script>
</body>

</html>
