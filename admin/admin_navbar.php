<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/admin_navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

</head>

<body>

    <div class="navbar_container">
        <div class="burger-icon" id="burger-icon">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>

        <img src="" alt="" id="logo-out">

        <nav id="navbar">
            <img src="../client_side/imgs/1.png" alt="" id="logo">
            <div id="links">
                <p><a href="add_room.php">Add</a></p>
                <p><a href="modify_room.php">Modify</a></p>
                <p><a href="list_room.php">List</a></p>
                <p><a href="client_sec.php">Client</a></p>
                <p><a href="../users/logout.php">Logout</a></p>
            </div>
            <img src="../imgs/x-solid.svg" alt="" id="logoX">
        </nav>
    </div>

    <script>
        //script for the burger-Icon on mobile
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