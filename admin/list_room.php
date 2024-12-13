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

// Fetch room data from the database
$query = "SELECT ID, RoomName, RoomNumber, RoomCategory, Description, RoomPrice, RoomImage FROM rooms";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

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
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['RoomName']) . '</td>'; #<!-- Display Room Name -->
                    echo '<td>' . htmlspecialchars($row['RoomNumber']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['RoomCategory']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Description']) . '</td>';
                    echo '<td>' . '$' . htmlspecialchars($row['RoomPrice']) . '</td>';
                    echo '<td>';
                    echo '<div class="action-buttons">';
                    echo '<button class="view-btn" onclick="showRoomDetails(\'' . htmlspecialchars($row['RoomName']) . '\', \'' . htmlspecialchars($row['RoomNumber']) . '\', \'' . htmlspecialchars($row['RoomCategory']) . '\', \'' . htmlspecialchars($row['Description']) . '\', \'' . htmlspecialchars($row['RoomPrice']) . '\', \'' . htmlspecialchars($row['RoomImage']) . '\')">View</button>';
                    echo '<button><a href="modify_room.php?id=' . htmlspecialchars($row['ID']) . 
                    '&roomName=' . htmlspecialchars($row['RoomName']) .  #<!-- Pass Room Name for modification -->
                    '&roomNumber=' . htmlspecialchars($row['RoomNumber']) . 
                    '&roomCategory=' . htmlspecialchars($row['RoomCategory']) . 
                    '&roomDescription=' . htmlspecialchars($row['Description']) . 
                    '&roomPrice=' . htmlspecialchars($row['RoomPrice']) . 
                    '&roomImage=' . htmlspecialchars($row['RoomImage']) . 
                    '" class="update-btn">Update</a></button>';
                    echo '<button><a href="delete_room.php?id=' . htmlspecialchars($row['ID']) . '" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this room?\')">Delete</a></button>';
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No rooms found</td></tr>';
            }
            ?>
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
            // Set the content of the modal
            document.getElementById('roomName').textContent = roomName;
            document.getElementById('roomNumber').textContent = roomNumber;
            document.getElementById('roomCategory').textContent = roomCategory;
            document.getElementById('roomDescription').textContent = roomDescription;
            document.getElementById('roomPrice').textContent = roomPrice;

            // Set the image source
            if (roomImage) {
                document.getElementById('roomImage').src = roomImage; // Assuming images are stored in 'uploads' folder
            }

            // Show the modal
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
