<?php
include('admin_navbar.php');
require '../includes/connection.php';

session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['name'] !== 'admin123') {
    header("Location: ../login.php");
    exit();
}

$error = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomNumber = trim($_POST['room-number']);
    $roomCategory = trim($_POST['room-category']);
    $roomStatus = "Empty";
    $roomDescription = trim($_POST['room-description']);
    $roomPrice = trim($_POST['room-price']);

    // Validate inputs
    if (empty($roomNumber) || empty($roomCategory) || empty($roomDescription) || empty($roomPrice)) {
        $error = "All fields are required.";
    } elseif (!is_numeric($roomPrice) || $roomPrice <= 0) {
        $error = "Room price must be a positive number.";
    } else {
        // Check if image is provided and valid
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
                $imagePath = $uploadDirectory . $imageNewName;

                if (!move_uploaded_file($_FILES['room-image']['tmp_name'], $imagePath)) {
                    $error = "Error uploading the image.";
                }
            }
        } else {
            $error = "Please upload a room image.";
        }

        // If no errors, proceed to check for room uniqueness and insert data
        if (empty($error)) {
            // Check for room number uniqueness
            $stmt = $conn->prepare("SELECT RoomNumber FROM rooms WHERE RoomNumber = ?");
            $stmt->bind_param("s", $roomNumber);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "Room number already exists.";
            } else {
                // Insert the data into the database
                $stmt = $conn->prepare("INSERT INTO rooms (RoomNumber, RoomCategory, Status, Description, RoomPrice, RoomImage) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $roomNumber, $roomCategory, $roomStatus, $roomDescription, $roomPrice, $imagePath);

                if ($stmt->execute()) {
                    $successMessage = "Room added successfully.";
                } else {
                    $error = "Error adding room: " . $stmt->error;
                }
                $stmt->close();
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
        <?php if (!empty($successMessage)): ?>
            <div class="success-message" style="color: green;">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="error-message" style="color: red;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Room addition form -->
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
        </form>
    </center>
</body>

</html>
