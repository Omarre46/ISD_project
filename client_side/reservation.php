<?php
include('../includes/connection.php');
include('../includes/navbar.php');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['room_id'], $_POST['room_name'], $_POST['room_price'], $_POST['check_in'], $_POST['check_out'])) {
        $room_id = htmlspecialchars($_POST['room_id']);
        $_SESSION['cart'][] = [
            'room_id' => htmlspecialchars($_POST['room_id']),
            'room_name' => htmlspecialchars($_POST['room_name']),
            'room_price' => htmlspecialchars($_POST['room_price']),
            'check_in' => htmlspecialchars($_POST['check_in']),
            'check_out' => htmlspecialchars($_POST['check_out'])
        ];
    }

    if (!isset($_SESSION['isReserved'])) {
        try {
            $sql = "UPDATE rooms SET Status = 1 WHERE ID = :room_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            $errors[] = "Error updating room status: " . $e->getMessage();
        }
    }
}

$errors = [];
$success = [];

if (isset($_POST['checkout']) && isset($_SESSION['cart'])) {
    if (isset($_SESSION['loggedin']) && isset($_SESSION['guest_id'])) {
        if (!isset($_SESSION['isReserved'])) {
            $guest_id = htmlspecialchars($_SESSION['guest_id']);

            foreach ($_SESSION['cart'] as $cart_item) {
                $room_id = htmlspecialchars($cart_item['room_id']);
                $check_in = htmlspecialchars($cart_item['check_in']);
                $check_out = htmlspecialchars($cart_item['check_out']);

                $check_in = date('Y-m-d', strtotime($check_in));
                $check_out = date('Y-m-d', strtotime($check_out));

                if (!$check_in || !$check_out) {
                    $errors[] = "Invalid date format.";
                    continue;
                }

                try {
                    $sql = "INSERT INTO reservation (Room_ID, Guest_ID, CheckIn, CheckOut) VALUES (:room_id, :guest_id, :check_in, :check_out)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
                    $stmt->bindParam(':guest_id', $guest_id, PDO::PARAM_INT);
                    $stmt->bindParam(':check_in', $check_in, PDO::PARAM_STR);
                    $stmt->bindParam(':check_out', $check_out, PDO::PARAM_STR);

                    if ($stmt->execute()) {
                        $_SESSION['isReserved'] = true;
                        $success[] = "Reservation successfully added";
                    } else {
                        $errors[] = "Error booking room.";
                    }
                } catch (PDOException $e) {
                    $errors[] = "Error inserting reservation: " . $e->getMessage();
                }
            }

            if (empty($errors)) {
                unset($_SESSION['cart']);
            }
        } else {
            $errors[] = "You have already reserved a room!";
        }
    } else {
        $errors[] = "You need to be logged in to complete the reservation.";
        $_SESSION['cart'] = [];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
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
                    <div class="check_in" onclick="handleSectionClick('check_in')">
                        <div class="font">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="title-information">
                            <h6>Check In</h6>
                            <h6 id="check_in">Select Date</h6>
                        </div>
                    </div>
                    <div class="check_out" onclick="handleSectionClick('check_out')">
                        <div class="font">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="title-information">
                            <h6>Check Out</h6>
                            <h6 id="check_out">Select Date</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div id="message-container" style="margin-top: 10px; font-size: 32px;"></div>
            <div class="calendar-container" id="calendar-container">
            </div>
            <div class="cancel-search-buttons">
                <div class="Cbutton">
                    <button onclick="resetValues()">Cancel</button>
                </div>
                <div class="Sbutton">
                    <button onclick="fetchRooms()">Search</button>
                </div>
            </div>
            <div class="searched-rooms" id="searched-rooms" style="display: none;">
                <div id="message" style="margin-top: 10px; font-size: 32px;"></div>
                <div class="rooms-container">

                </div>
            </div>
        </div>

        <div class="cart-container">
            <h3>Your Cart</h3>
            <form id="cart-form" method="POST">
                <?php
                if (htmlspecialchars(isset($_SESSION['cart'])) && htmlspecialchars(count($_SESSION['cart'])) > 0) {
                    $total = 0;
                    foreach ($_SESSION['cart'] as $cart_item) {
                        $check_in_date = htmlspecialchars(strtotime($cart_item['check_in']));
                        $check_out_date = htmlspecialchars(strtotime($cart_item['check_out']));
                        $nights = ($check_out_date - $check_in_date) / (60 * 60 * 24);

                        if ($nights <= 0) {
                            echo '<p>Invalid check-in and check-out dates.</p>';
                            continue;
                        }

                        $room_total_price = $nights * htmlspecialchars($cart_item['room_price']);

                        echo '<p>Room: ' . htmlspecialchars($cart_item['room_name']) . '</p>';
                        echo '<p>Price: $' . htmlspecialchars($cart_item['room_price']) . ' per night</p>';
                        echo '<p>Check-in: ' . htmlspecialchars($cart_item['check_in']) . '</p>';
                        echo '<p>Check-out: ' . htmlspecialchars($cart_item['check_out']) . '</p>';
                        $total += $room_total_price;
                    }
                    echo '<p class="cart-total">Total: $' . number_format($total, 2) . '</p>';
                } else {
                    echo '<p>Your cart is empty.</p>';
                }
                ?>
                <button type="submit" name="checkout">Checkout</button>
            </form>
            <?php
            if (!empty($errors)) {
                echo '<div class="error-messages">';
                foreach ($errors as $error) {
                    echo '<p class="error">' . htmlspecialchars($error) . '</p>';
                }
                echo '</div>';
            }

            if (!empty($success)) {
                echo '<div class="success-messages">';
                foreach ($success as $message) {
                    echo '<p class="success">' . htmlspecialchars($message) . '</p>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <div class="footer">
        <?php include('../includes/footer.php'); ?>
    </div>

    <script src="scripts/reservation.js"></script>
    <script src="scripts/search-rooms.js"></script>
    <script src="scripts/cart.js"></script>
    <script>

        function fetchRooms() {
            const checkInDate = document.getElementById('check_in').textContent.trim();
            const checkOutDate = document.getElementById('check_out').textContent.trim();

            if (checkInDate === "Select Date" || checkOutDate === "Select Date") {
                alert("Please select both check-in and check-out dates.");
                return;
            }

            function formatLocalDate(dateString) {
                const date = new Date(dateString);
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            const formattedCheckInDate = formatLocalDate(checkInDate);
            const formattedCheckOutDate = formatLocalDate(checkOutDate);

            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        const roomsContainer = document.querySelector(".rooms-container");
                        roomsContainer.innerHTML = this.responseText;
                        document.getElementById("searched-rooms").style.display = "block";
                    } 
                }
            };
            xmlhttp.open("GET", `fetch_rooms.php?check_in=${formattedCheckInDate}&check_out=${formattedCheckOutDate}`, true);
            xmlhttp.send();
        }
    </script>
</body>

</html>