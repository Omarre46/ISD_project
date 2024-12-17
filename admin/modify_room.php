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

// Retrieve query parameters for prepopulating form fields
$roomId = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$roomNumber = isset($_GET['roomNumber']) ? htmlspecialchars($_GET['roomNumber']) : '';
$roomName = isset($_GET['roomName']) ? htmlspecialchars($_GET['roomName']) : ''; // Added RoomName
$roomCategory = isset($_GET['roomCategory']) ? htmlspecialchars($_GET['roomCategory']) : '';
$roomDescription = isset($_GET['roomDescription']) ? htmlspecialchars($_GET['roomDescription']) : '';
$roomPrice = isset($_GET['roomPrice']) ? htmlspecialchars($_GET['roomPrice']) : '';
$roomImage = isset($_GET['roomImage']) ? htmlspecialchars($_GET['roomImage']) : '';

// Initialize messages
$error = "";
$successMessage = "";

// Handle form submission for updating the room
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomId = trim($_POST['room-id']);
    $roomNumber = trim($_POST['room-number']);
    $roomName = trim($_POST['room-name']); // Added RoomName
    $roomCategory = trim($_POST['room-category']);
    $roomDescription = trim($_POST['room-description']);
    $roomPrice = trim($_POST['room-price']);
    $imagePath = $roomImage; // Use the existing image path by default

    // Validate inputs
    if (empty($roomName) || empty($roomNumber) || empty($roomCategory) || empty($roomDescription) || empty($roomPrice)) {
        $error = "All fields are required.";
    } elseif (!is_numeric($roomPrice) || $roomPrice <= 0) {
        $error = "Room price must be a positive number.";
    } else {
        // Check if a new image is provided
        if (isset($_FILES['room-image']) && $_FILES['room-image']['error'] == 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $maxSize = 3 * 1024 * 1024; // 3MB

            if (!in_array($_FILES['room-image']['type'], $allowedTypes)) {
                $error = "Invalid image type. Only JPEG, PNG, and JPG are allowed.";
            } elseif ($_FILES['room-image']['size'] > $maxSize) {
                $error = "Image size exceeds the maximum limit of 3MB.";
            } else {
                $imageNewName = uniqid('', true) . '.' . pathinfo($_FILES['room-image']['name'], PATHINFO_EXTENSION);
                $uploadDirectory = './room_imgs/';
                $imagePath = $imageNewName;

                if (!move_uploaded_file($_FILES['room-image']['tmp_name'], $imagePath)) {
                    $error = "Error uploading the image.";
                }
            }
        }

        // If no errors, update the database
        if (empty($error)) {
            $stmt = $conn->prepare("UPDATE rooms SET RoomName = ?, RoomNumber = ?, RoomCategory = ?, Description = ?, RoomPrice = ?, RoomImage = ? WHERE ID = ?");
            $stmt->bind_param("ssssssi", $roomName, $roomNumber, $roomCategory, $roomDescription, $roomPrice, $imagePath, $roomId);

            if ($stmt->execute()) {
                $successMessage = "Room updated successfully.";
                sleep(2);
                header("Location:../admin/list_room.php");
            } else {
                $error = "Error updating room: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Room</title>
    <link rel="stylesheet" href="style/modify_room.css">
</head>

<body>
    <center>
        <h1>Modify Room</h1>

        <!-- Display success or error message -->
        <?php if (!empty($successMessage)): ?>
            <div class="success-message" style="color: green;">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="error-message" style="color: red;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="modify_room.php?id=<?php echo $roomId; ?>" method="POST" enctype="multipart/form-data">
            <p>
                <label for="room-id">Room ID:</label>
                <input type="text" id="room-id" name="room-id" value="<?php echo $roomId; ?>" readonly>
            </p>
            <p>
                <label for="room-name">Room Name:</label>
                <input type="text" id="room-name" name="room-name" value="<?php echo $roomName; ?>" placeholder="Enter Room Name">
            </p>
            <p>
                <label for="room-number">Room Number:</label>
                <input type="text" id="room-number" name="room-number" value="<?php echo $roomNumber; ?>" placeholder="Enter Room Number">
            </p>
            <p>
                <label for="room-category">Room Category:</label>
                <input type="text" id="room-category" name="room-category" value="<?php echo $roomCategory; ?>" placeholder="Enter Room Category">
            </p>
            <p>
                <label for="room-description">Room Description:</label>
                <input type="text" id="room-description" name="room-description" value="<?php echo $roomDescription; ?>" placeholder="Enter Room Description">
            </p>
            <p>
                <label for="room-price">Room Price:</label>
                <input type="text" id="room-price" name="room-price" value="<?php echo $roomPrice; ?>" placeholder="Enter Room Price">
            </p>
            <p>
                <label for="room-image">Current Image:</label>
                <br>
                <img src="<?php echo $roomImage; ?>" alt="Room Image" style="width: 200px; height: auto; margin: 10px 0;">
            </p>
            <p>
                <label for="room-image">Upload New Image:</label>
                <input type="file" id="room-image" name="room-image" accept="image/*">
            </p>
            <div class="form-actions">
                <input type="submit" value="Modify">
            </div>
        </form>
    </center>
</body>

</html>
