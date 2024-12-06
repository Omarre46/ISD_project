<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/login.css">
</head>

<body>

    <div class="container">
        <div class="box">
        <a href="#" id="back-home" class="login"><img id="x_button" src="../client_side/imgs/x-solid.svg" alt=""></a>

            <h1>Sign in</h1>
            
            <form action="sign_in.php" method="post">
                <label>Username</label>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input id="username" type="text" name="username" placeholder="Enter Username">
                </div>
                <label>Password</label>
                <div>
                    <i class="fa-solid fa-lock"></i>
                    <input id="password" type="password" name="password" placeholder="Enter Password">
                </div>
                <a href="#" class="forgot">Forgot Password?</a>
                <input type="submit" name="submit" value="Sign in">
            </form>
            <a href="register.php" class="register">Register</a>
            
            <script>
                const previousPage = document.referrer;
                const backHomeButton = document.getElementById('back-home');

                if (previousPage && previousPage != window.location.href) {
                    backHomeButton.href = previousPage;
                } else {
                    backHomeButton.href = '/ISD_project_ongit/ISD_project/client_side/home.php';
                }
            </script>



        </div>
    </div>
</body>

</html>