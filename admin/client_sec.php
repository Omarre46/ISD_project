<?php
include('admin_navbar.php');
require '../includes/connection.php'; // Database connection file

// Start session
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

// Fetch client data securely using prepared statements
try {
    $stmt = $conn->prepare("
        SELECT 
            guest.ID AS GuestID,
            guest.Name AS GuestName,
            guest.Username AS Username,
            guest.Email AS Email,
            guest.DateCreated AS DateCreated,
            rooms.RoomNumber AS RoomNumber,
            rooms.RoomName AS RoomName
        FROM guest
        LEFT JOIN reservation ON guest.ID = reservation.Guest_ID
        LEFT JOIN rooms ON reservation.Room_ID = rooms.ID
        ORDER BY guest.ID ASC
    ");
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    die("Error fetching client data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Client List</title>
    <link rel="stylesheet" href="style/client_sec.css">
</head>

<body>
    <center>
        <h1 class="error" style="color: red; font-size:25px;">Cannot display admin panel on small devices</h1>
        <h2>Client List</h2>
        <table>
            <thead>
                <tr>
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    $id = htmlspecialchars($row['GuestID'], ENT_QUOTES, 'UTF-8');
                    $name = htmlspecialchars($row['GuestName'], ENT_QUOTES, 'UTF-8');
                    $username = htmlspecialchars($row['Username'], ENT_QUOTES, 'UTF-8');
                    $email = htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8');
                    $roomNumber = htmlspecialchars($row['RoomNumber'], ENT_QUOTES, 'UTF-8');
                    $roomType = htmlspecialchars($row['RoomName'], ENT_QUOTES, 'UTF-8');
                    $dateCreated = htmlspecialchars($row['DateCreated'], ENT_QUOTES, 'UTF-8');

                    // Handle cases where RoomNumber and RoomType may be NULL
                    $roomNumber = empty($roomNumber) ? "No rooms reserved" : $roomNumber;
                    $roomType = empty($roomType) ? "No rooms reserved" : $roomType;

                    echo "<tr>
                            <td>{$id}</td>
                            <td>{$name}</td>
                            <td>{$username}</td>
                            <td>{$email}</td>
                            <td>{$dateCreated}</td>
                            <td>
                                <div class='action-buttons'>
                                    <button class='check-btn' onclick='showReservationDetails(\"{$roomNumber}\", \"{$roomType}\")'>Check Reservation</button>
                                    <button class='delete-btn' onclick='confirmDelete({$id})'>Delete</button>
                                </div>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal Popup for Reservation Details -->
        <div id="reservationModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h3>Reservation Details</h3>
                <p><strong>Room Number:</strong> <span id="roomNumber"></span></p>
                <p><strong>Room Type:</strong> <span id="roomType"></span></p>
            </div>
        </div>

    </center>

    <script>
        // JavaScript function to confirm deletion
        function confirmDelete(clientId) {
            if (confirm("Are you sure you want to delete this client?")) {
                window.location.href = `delete_client.php?id=${clientId}`;
            }
        }

        // Function to show the reservation details in a modal
        function showReservationDetails(roomNumber, roomType) {
            // Set the content of the modal
            document.getElementById('roomNumber').textContent = roomNumber;
            document.getElementById('roomType').textContent = roomType;

            // Show the modal
            document.getElementById('reservationModal').style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('reservationModal').style.display = "none";
        }

        // Close the modal when the user clicks outside the modal content
        window.onclick = function(event) {
            if (event.target == document.getElementById('reservationModal')) {
                closeModal();
            }
        }
    </script>
</body>

</html>
