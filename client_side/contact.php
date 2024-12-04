<div class="navbar">
    <?php include('../includes/navbar.php'); ?>
</div>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/contact.css">
    <link rel="stylesheet" href="../includes/style/navbar.css">
    <link rel="stylesheet" href="../includes/style/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   </head>

<body>

<div class="contact">
        <div class="google-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13246.131959710738!2d35.4799490871582!3d33.90167949999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151f16dd38749253%3A0xc25f0ac5ac2581fc!2sFour%20Seasons%20Hotel%20Beirut!5e0!3m2!1sen!2slb!4v1733312203465!5m2!1sen!2slb" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="info">
            <div class="loc">
                <i class="fa-solid fa-location-dot"></i>
                <h4><i>Four Seasons Hotel, Beirut, Lebanon</i></h4>
            </div>

            <div class="phone">
                <i class="fa-solid fa-phone"></i>
                <h4><i>Phone: 961 (1) 761000</i></h4>
            </div>

            <div class="icons">
                <a href="https://x.com/FSBeirut"><i class="fa-brands fa-twitter"></i></a>
                <a href="https://www.facebook.com/FourSeasonsHotelBeirut" target="_blank"><i class="fa-brands fa-facebook" style="color: #055ffa;"></i></a>
                <a href="https://www.instagram.com/fsbeirut" target="_blank"><i class="fa-brands fa-square-instagram" style="color: #f70240;"></i></a>
                <h4><i>Visit us</i></h4>
            </div>
        </div>
    </div>

    <br>

    <div class="contact-form-container">
        <h2>Contact Us</h2>
        <form action="#">
            <div class="form-group">
                <input type="text" name="first_name" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="last_name" placeholder="Last Name" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="tel" name="phone" placeholder="Phone Number" required>
            </div>

            <div class="form-group">
                <textarea name="description" placeholder="Write your message here..." required></textarea>
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>


    <div class="footer">
        <?php include('../includes/footer.php'); ?>
    </div>
</body>

</html>