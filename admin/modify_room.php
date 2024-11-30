<?php include("admin_navbar.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/modify_room.css">
</head>

<body>

    <center>
        <h1>Modify Room</h1>

        <form action="">
            <p>
                <label for="room-id">Room ID:</label>
                <input type="text" id="room-id" name="room-id" placeholder="Enter Room ID">
            </p>
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
                <input type="text" id="room-image" name="room-image" placeholder="Enter Image URL">
            </p>
            <div class="form-actions">
                <input type="submit" value="Modify">
                <input type="reset" value="Reset">
            </div>
        </form>
    </center>
    
</body>

</html>