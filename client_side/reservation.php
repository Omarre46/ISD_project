<div class="navbar">
    <?php include('../includes/navbar.php'); ?>
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
                    <div class="check-in"  onclick="handleSectionClick('check-in')">
                        <div class="font">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="title-information">
                            <h6>Check In</h6>
                            <h6 id="check-in-date">Select Date</h6>
                        </div>
                    </div>
                    <div class="check-out"  onclick="handleSectionClick('check-out')">
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
            <div class="calendar-container" id="calendar-container"></div>
        </div>
        <div class="cart">
            <h1>Cart</h1>
        </div>
    </div>

    <div class="footer">
        <?php include('../includes/footer.php'); ?>
    </div>

    <script src="scripts/reservation.js"></script>

</body>

</html>