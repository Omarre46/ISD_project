<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

</head>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const links = document.querySelectorAll("#links a");
        const currentPage = window.location.pathname.split("/").pop();

        links.forEach(link => {
            if (link.getAttribute("href") === currentPage) {
                link.classList.add("active");
            }
        });
    });
</script>


<body>

    <div class="navbar_container">
        <div class="burger-icon" id="burger-icon">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>

        <img src="../client_side/imgs/1.png" alt="" id="logo-out">

        <nav id="navbar">
            <img src="../client_side/imgs/1.png" alt="" id="logo">
            <div id="links">
                <p><a href="../client_side/home.php">Home</a></p>
                <p><a href="../client_side/service.php">Our Services</a></p>
                <p><a href="../client_side/reservation.php">Reservation</a></p>
                <p><a href="../client_side/about.php">About Us</a></p>
                <p><a href="../client_side/contact.php">Contact Us</a></p>

                <?php
                session_start();
                if (isset($_SESSION['loggedin'])) {

                    echo "<p><a href='../users/logout.php'>Sign out</a></p>";
                } else {
                    echo '<p><a href="../users/register.php">Sign Up</a></p>';
                    echo '<p><a href="../users/login.php">Login</a></p>';
                }
                ?>
            </div>
            <img src="./imgs/x-solid.svg" alt="" id="logoX">
        </nav>
    </div>

    <script>
        const burgerIcon = document.getElementById('burger-icon');
        const navbar = document.getElementById('navbar');
        const Logo = document.getElementById('logoX');

        burgerIcon.addEventListener('click', () => {
            navbar.classList.toggle('show');

        });
        Logo.addEventListener('click', () => {
            navbar.classList.toggle('show');
        })
    </script>

</body>

</html>