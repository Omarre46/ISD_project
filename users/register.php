<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="style/register.css">
</head>
<body>
<div class="container">
        <div class="box">
            <h1>Register</h1>
            <form>
                <label>Full Name</label>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="name" placeholder="Enter Full Name">
                </div>

                <label>Username</label>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" placeholder="Enter Username">
                </div>

                <label>Email</label>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input id="email" type="text" name="email" placeholder="Enter Email">
                </div>

                <label>Password</label>
                <div>
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Enter Password">
                </div>

                <label>Repeat Password</label>
                <div>
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="repeatPassword" placeholder="Enter Password">
                </div>

                <a href="#"><input type="submit" name="submit" value="Register"></a>
            </form>
            <h6>Already have an account?</h6>
            <a href="login.php" class="sign">Sign in</a>
        </div>
    </div>
</body>
</html>
