<?php
include('admin_navbar.php');
require '../includes/connection.php';

// Start session to check if the user is logged in
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

// Initialize error and success messages
$error = "";
$successMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $roomNumber = trim($_POST['room-number']);
    $roomCategory = trim($_POST['room-category']);
    $roomStatus="Empty";
    $roomDescription = trim($_POST['room-description']);
    $roomPrice = trim($_POST['room-price']);
   
    
    // Check if the image file is provided
    if (isset($_FILES['room-image']) && $_FILES['room-image']['error'] == 0) {
        // Get image details
        $imageTmpName = $_FILES['room-image']['tmp_name'];
        $imageName = $_FILES['room-image']['name'];
        $imageSize = $_FILES['room-image']['size'];
        $imageError = $_FILES['room-image']['error'];

        // Define allowed image types and max size (e.g., 5MB)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 3 * 1024 * 1024; // 3MB in bytes

        // Check if the image type is allowed
        if (!in_array($_FILES['room-image']['type'], $allowedTypes)) {
            $error = "Invalid image type. Only JPEG, PNG, and JPG are allowed.";
        } elseif ($imageSize > $maxSize) {
            $error = "Image size exceeds the maximum limit of 3MB.";
        } else {
            // Generate a unique file name to avoid conflicts
            $imageNewName = uniqid('', true) . '.' . pathinfo($imageName, PATHINFO_EXTENSION);

            // Define the upload directory
            $uploadDirectory = './room_imgs/'; // Make sure this folder exists and is writable

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($imageTmpName, $uploadDirectory . $imageNewName)) {
                // File uploaded successfully, set the image path
                $imagePath = $uploadDirectory . $imageNewName;
            } else {
                $error = "Error uploading the image.";
            }
        }
    } else {
        $error = "Please upload a room image.";
    }

    // If no errors, insert the room data into the database
    if (empty($error)) {
        // Check if required fields are empty
        if (empty($roomNumber) || empty($roomCategory) || empty($roomDescription) || empty($roomPrice)) {
            $error = "All fields are required.";
        } else {
            // Insert the data into the database using prepared statements
            try {
                $stmt = $conn->prepare("INSERT INTO rooms (RoomNumber,RoomCategory,Status, Description, RoomPrice, RoomImage) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $roomNumber, $roomCategory,$roomStatus, $roomDescription, $roomPrice, $imagePath);

                // Execute the statement
                if ($stmt->execute()) {
                    $error = "Room added successfully.";
                } else {
                    $error = "Error adding room: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            } catch (Exception $e) {
                $error = "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <link rel="stylesheet" href="style/add_room.css">
</head>

<body>
    <center>
        <h1>Add Room</h1>

        <!-- Display success or error message -->
        <?php if (isset($successMessage)): ?>
            <div class="success-message" style="color: green;">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="error-message" style="color: red;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Room addition form without Room ID -->
        <form action="add_room.php" method="POST" enctype="multipart/form-data">
            <p>
                <label for="room-number">Room Number:</label>
                <input type="text" id="room-number" name="room-number" placeholder="Enter Room Number">
            </p>
            <p>
                <label for="room-category">Room Category:</label>
                <input type="text" id="room-category" name="room-category" placeholder="Enter Room Category">
            </p>
            <p>
                <label for="room-description">Room Description:</label>
                <input type="text" id="room-description" name="room-description" placeholder="Enter Room Description">
            </p>
            <p>
                <label for="room-price">Room Price:</label>
                <input type="text" id="room-price" name="room-price" placeholder="Enter Room Price">
            </p>
            <p>
                <label for="room-image">Room Image:</label>
                <input type="file" id="room-image" name="room-image" accept="image/*">
            </p>
            <div class="form-actions">
                <input type="submit" value="Add Room">
                <input type="reset" value="Reset">
            </div>
            <span style="color: red; font-size:large;font-weight:bold;"><?php echo $error;?></span>
        </form>
    </center>
</body>

</html>
