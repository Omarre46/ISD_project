<div class="navbar">
    <?php
     include('../includes/navbar.php');
     if (isset($_SESSION['loggedin']))
        include('../includes/service.php');
    ?>
</div>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/service.css">
    <link rel="stylesheet" href="../includes/style/navbar.css">
    <link rel="stylesheet" href="../includes/style/footer.css">
</head>

<body>

    <div class="upper-service">
        <div class="services">
            <div class="services-header">
                <div class="services-title">
                    <h5>Four Seasons Hotel</h5>
                    <h1>SERVICES & AMENITITES</h1>
                </div>
                <div class="services-topic">
                    <p>HOTEL AMENITIES | OUR SERVICES | FAMILIES AT BEIRUT | COMPLIMENTARY SERVICES</p>
                </div>
                <div class="service-body">
                    <div class="service-main-img">
                        <img src="./imgs/hotel_aementy.avif">
                    </div>
                    <div class="contact-part">
                        <div class="contact-title">
                            <h6>We can arrange virsually anything.</h6>
                        </div>
                        <div class="phone-number">
                            <h6>+961 (1) 761000</h6>
                        </div>
                        <div class="contact-button">
                            <a href="../client_side/contact.php">contact</a>
                        </div>
                    </div>
                    <div class="amenities">
                        <div class="amenities-title">
                            <h5>Hotel amenities</h5>
                        </div>
                        <div class="carousel">
                            <div class="carousel-inner">
                                <!-- The items will be dynamically populated by JavaScript -->
                            </div>
                        </div>
                        <div class="more-amenities">
                            <h2>More Amenities</h2>
                            <ul>
                                <div class="left-amenities">
                                    <li>On-site Restaurant</li>
                                    <li>Three Lounges</li>
                                    <li>Year-round Rooftop Bar & Lounge</li>
                                    <li>Seasonal Shisha Terrace</li>
                                </div>
                                <div class="right-amenities">
                                    <li>Seasonal Rooftop Whirlpool</li>
                                    <li>Steam Room and Sauna</li>
                                    <li>Pet-friendly Rooms</li>
                                    <li>Children 5 and Under Eat for Free</li>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lower-services">
        <div class="more-services">
            <h2>More services</h2>
            <ul>
                <div class="left-services">
                    <li>Multilingual Concierge</li>
                    <li>24-hour In-Room Dining</li>
                    <li>Laundry and Dry Cleaning</li>
                </div>
                <div class="right-services">
                    <li>Airport Transportation</li>
                    <li>Valet Parking</li>
                    <li>Fax and Photocopy</li>
                </div>
            </ul>
        </div>
        <div class="complimentary-services">
            <h2>Complimentary services</h2>
            <ul>
                <div class="complimentary-left-services">
                    <li>Premium Wi-Fi</li>
                    <li>Newspapers</li>
                    <li>L’Occitane Bath Products in Guest Rooms</li>
                    <li>Coffee or Tea with Your Wake-Up Call</li>
                </div>
                <div class="complimentary-right-services">
                    <li>Twice-daily Housekeeping</li>
                    <li>Shoeshine Service</li>
                    <li>Bulgari Bath Products in Suites</li>
                    <li>In-Room Coffee Maker</li>
                </div>
            </ul>
        </div>
        <div class="families">
            <div class="families-title">
                <h2>Families At Four Seasons</h2>
            </div>
            <div class="familes-img">
                <img src="imgs/FSH_1199_original.jpg">
            </div>
            <div class="description-families">
                <p>We make sure our youngest guests feel noticed right from the <br>
                    start with a welcome gift and special kids' check-in materials.</p>
            </div>
            <div class="more-for-kids">
                <h2>More For Kids</h2>
                <ul>
                    <div class="left-services-kids">
                        <li>Kids and Teen Spa Treatments</li>
                        <li>Welcome Amenities</li>
                        <li>Board Games and Movies</li>
                    </div>
                    <div class="right-services-kids">
                        <li>Playstation consoles on request</li>
                        <li>Complimentary Children’s Toiletries</li>
                        <li>Family-Friendly Off-Site Activities</li>
                    </div>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer">
        <?php
        include('../includes/footer.php');
        ?>
    </div>

    <script src="scripts/carousel.js"></script>
</body>

</html>