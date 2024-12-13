<div class="navbar">
    <?php
    include('../includes/connection.php');
    include('../includes/navbar.php');

    $query = "SELECT RoomName, RoomNumber, RoomCategory, Description, RoomPrice, RoomImage FROM rooms";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    ?>
</div>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/reservation.css">
    <link rel="stylesheet" href="../includes/style/navbar.css">
    <link rel="stylesheet" href="../includes/style/footer.css">
</head>

<body>
    <div class="wrapper">
        <div class="reservation">
            <div class="reserve-page-title">
                <h2>Welcome To Four Seasons Hotel</h2>
            </div>
            <div class="reserve">
                <div class="reserve-information">
                    <div class="guests" onclick="handleSectionClick('guests')">
                        <button onclick="togglePopup()">
                            <div class="font">
                                <i class="fa-solid fa-person"></i>
                            </div>
                            <div class="title-information">
                                <h6>Guests</h6>
                                <h6 id="guest-info">0 Adults, 0 Children</h6>
                            </div>
                        </button>
                        <div class="popup" id="guest-popup">
                            <h6>Adults:</h6>
                            <select id="adults">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            <h6>Children:</h6>
                            <select id="children">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            <button class="cancel-button" onclick="closePopup()">Cancel</button>
                            <button class="apply-button" onclick="applyChanges()">Apply</button>
                        </div>
                    </div>
                    <div class="check-in" onclick="handleSectionClick('check-in')">
                        <div class="font">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="title-information">
                            <h6>Check In</h6>
                            <h6 id="check-in-date">Select Date</h6>
                        </div>
                    </div>
                    <div class="check-out" onclick="handleSectionClick('check-out')">
                        <div class="font">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="title-information">
                            <h6>Check Out</h6>
                            <h6 id="check-out-date">Select Date</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="calendar-container" id="calendar-container">

            </div>
            <div class="cancel-search-buttons">
                <div class="Cbutton">
                    <button onclick="resetValues()">Cancel</button>
                </div>
                <div class="Sbutton">
                    <button onclick="showRooms()">Search</button>
                </div>
            </div>
            <div class="searched-rooms" id="searched-rooms" style="display: none;">
                <div class="rooms-container">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="room">';
                            echo '<img src="../admin/' . $row['RoomImage'] . '">';
                            echo '<div class="room-info">';
                            echo '<h3> Room Number: ' . htmlspecialchars($row['RoomNumber']) . '</h3>';
                            echo '<h3>' . htmlspecialchars($row['RoomName']) . '</h3>';
                            echo '<h3>' . htmlspecialchars($row['RoomCategory']) . ' Room</h3>';
                            echo '<p>' . htmlspecialchars($row['Description']) . '</p>';
                            echo '<div class="price">' . '$' . htmlspecialchars($row['RoomPrice']) . ' Per Night</div>';
                            echo '<button onclick="updateCart(\'' . $row['RoomNumber'] . '\', ' . $row['RoomPrice'] . ')">Book Now</button>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="room">';
                        echo '<div class="room-info">';
                        echo '<h3>No Rooms Found</h3>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="cart-container">
            <h3>Your Cart</h3>
            <form id="cart-form" method="POST">
                <p>Room Number: <span id="room-number">0</span></p>
                <p>Items: <span id="cart-items">0</span></p>
                <p>Adults: <span id="cart-adults">0 Adults</span></p>
                <p>Children: <span id="cart-children">0 Children</span></p>
                <p>Dates: <span id="cart-dates">Not Selected</span></p>
                <p class="cart-total">Total: $<span id="cart-total">0.00</span></p>
                <button type="submit">Checkout</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <?php include('../includes/footer.php'); ?>
    </div>

    <script src="scripts/reservation.js"></script>
    <script src="scripts/search-rooms.js"></script>
    <script src="scripts/cart.js"></script>


</body>

</html>