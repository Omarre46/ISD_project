<?php include("admin_navbar.php")?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/list_room.css">
</head>

<body>
    <h2>Room List</h2>
    <table>
        <thead>
            <tr>
                <th>Room ID</th>
                <th>Room Number</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>101</td>
                <td>Deluxe</td>
                <td>Spacious room with a king bed</td>
                <td>$120</td>
                <td>
                    <div class="action-buttons">
                        <button class="view-btn">View</button>
                        <button class="update-btn">Update</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>102</td>
                <td>Standard</td>
                <td>Cozy room with queen bed</td>
                <td>$80</td>
                <td>
                    <div class="action-buttons">
                        <button class="view-btn">View</button>
                        <button class="update-btn">Update</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>103</td>
                <td>Suite</td>
                <td>Luxury suite with a balcony</td>
                <td>$200</td>
                <td>
                    <div class="action-buttons">
                        <button class="view-btn">View</button>
                        <button class="update-btn">Update</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>