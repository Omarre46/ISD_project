<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/home.css">
    <link rel="stylesheet" href="../includes/style/navbar.css">
    <link rel="stylesheet" href="../includes/style/footer.css">
</head>

<body>

    <div class="container">
        <div class="navbar">
            <?php
            include('../includes/connection.php'); // Ensure this includes your PDO setup
            include('../includes/navbar.php');

            if (htmlspecialchars(isset($_SESSION['loggedin']))) {
                $guest_id = htmlspecialchars($_SESSION['guest_id']);
                $hasReservation = false;
                try {
                    $query = "SELECT COUNT(*) as reservation_count FROM reservation WHERE Guest_ID = :guest_id";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':guest_id', $guest_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row) {
                        $hasReservation = $row['reservation_count'] > 0;
                    }
                } catch (PDOException $e) {
                    error_log("Database error: " . $e->getMessage());
                }

                if ($hasReservation) {
                    include('../includes/service.php');
                }
            }
            ?>
        </div>

        <div class="contents">
            <h1>Four Seasons Hotel Beirut</h1>
            <p>At Four Seasons, we redefine luxury by blending timeless elegance with personalized service, <br>
                creating unforgettable experiences that make every stay feel like home.</p>
            <a href="service.php"><button>Explore</button></a>
        </div>

        <div class="services">
            <div class="service_box">
                <img src="./imgs/circle-solid.svg" alt="">
                <h1>Laundry and Dry Cleaning</h1>
                <p>Our laundry and cleaning service ensures your clothes and linens are treated with the utmost care and attention. From fresh linens to expertly cleaned garments, we provide a premium service that keeps you feeling comfortable and at home throughout your stay.</p>
            </div>

            <div class="service_box">
                <img src="./imgs/circle-solid.svg" alt="">
                <h1>Airport Transportation</h1>
                <p>Enjoy a seamless and stress-free arrival with our airport transportation service. Whether you're arriving or departing, our reliable and comfortable vehicles ensure you travel in style and convenience, making your journey as pleasant as possible.</p>
            </div>

        </div>

        <div class="check_resrevation_home">
            <h1>Reserve Now</h1>
            <div class="check_boxes">
                <a href="" class="check_box">Check-In/Out</a>
                <a href="" class="check_box">Guests</a>
                <a href="" class="check_box">Promo Codes</a>
                <a href="reservation.php" class="check_box">Check Availability</a>
            </div>
        </div>

        <div class="services_row">
            <img src="../client_side/imgs/hotel_sauna.jpg" alt="">
            <div class="text">
                <h1>Steam Room and Sauna</h1>
                <p>Relax and rejuvenate in our luxurious steam room and sauna, where tranquility meets wellness. Immerse yourself in soothing heat that helps detoxify, relieve stress, and refresh your mind and body, providing the perfect escape after a busy day.</p>
            </div>
        </div>

        <div class="services_row_inverted">
            <div class="text">
                <h1>Year-round Rooftop Bar & Lounge</h1>
                <p>Elevate your experience at our year-round rooftop bar and lounge, where stunning city views meet expertly crafted cocktails. Whether you're unwinding with friends or enjoying a quiet evening, our rooftop provides the perfect atmosphere for relaxation and celebration, all year long.</p>
            </div>
            <img src="../client_side/imgs/hotel_bar.jpg" alt="">
        </div>

        <div class="services_row_mobile1">
            <img src="../client_side/imgs/hotel_sauna.jpg" alt="">
            <div class="text">
                <h1>Steam Room and Sauna</h1>
                <p>Relax and rejuvenate in our luxurious steam room and sauna, where tranquility meets wellness. Immerse yourself in soothing heat that helps detoxify, relieve stress, and refresh your mind and body, providing the perfect escape after a busy day.</p>
            </div>

        </div>
        <div class="services_row_mobile2">
            <div class="text">
                <h1>Year-round Rooftop Bar & Lounge</h1>
                <p>Elevate your experience at our year-round rooftop bar and lounge, where stunning city views meet expertly crafted cocktails. Whether you're unwinding with friends or enjoying a quiet evening, our rooftop provides the perfect atmosphere for relaxation and celebration, all year long.</p>
            </div>
            <img src="../client_side/imgs/hotel_bar.jpg" alt="">
        </div>

        <div class="footer">
            <?php include('../includes/footer.php'); ?>
        </div>
    </div>

</body>

</html>