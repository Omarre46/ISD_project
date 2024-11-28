<?php
include('admin_navbar.php')

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/client_sec.css">
</head>
<center>
    <h1 class="error" style="color: red; font-size:25px;">Cannot display admin panel on small devices</h1>
<body>
    <h2>Client List</h2>
    <table>
        <thead>
            <tr>
                <th>Client ID</th>
                <th>Client Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>johndoe@example.com</td>
                <td>+1 123 456 7890</td>
                <td>
                    <div class="action-buttons">
                        <button class="check-btn">Check Reservation</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jane Smith</td>
                <td>janesmith@example.com</td>
                <td>+1 987 654 3210</td>
                <td>
                    <div class="action-buttons">
                        <button class="check-btn">Check Reservation</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Sam Wilson</td>
                <td>samwilson@example.com</td>
                <td>+1 456 789 0123</td>
                <td>
                    <div class="action-buttons">
                        <button class="check-btn">Check Reservation</button>
                        <button class="delete-btn">Delete</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</center>
</html>