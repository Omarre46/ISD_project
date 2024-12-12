<?php
session_start();
require "../includes/connection.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($username) || empty($email) || empty($password)) {
        $error = "Please fill all the fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check for duplicate entries (username, email)
        $stmt = $conn->prepare("SELECT * FROM guest WHERE Username = ? OR Email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username or Email already exists.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into the database
            $stmt = $conn->prepare("INSERT INTO guest (Name, Username, Email, Password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $username, $email, $hashedPassword);

            if ($stmt->execute()) {
                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
                $_SESSION['email'] = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

                header("Location: ../client_side/home.php");
                exit();
            } else {
                $error = "Error occurred during registration. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="style/register.css">
    <link rel="stylesheet" href="../includes/style/navbar.css">
    <link rel="stylesheet" href="../includes/style/footer.css">
</head>

<body>
    <div class="container">
        <div class="box">
            <a href="#" id="back-home" class="signin"><img id="x_button" src="./img/x-solid.svg" alt=""></a>

            <h1>Register</h1>
            <form action="register.php" method="post">
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

                 
                <span style="color: red;font-size:larger"><?php echo $error; ?></span>
                <a href="#"><input type="submit" name="submit" value="Register"></a>
              
            </form>
            <h6>Already have an account?</h6>
            <a href="login.php" class="signin">Sign in</a>


            <script>
                const previousPage = document.referrer;
                const backHomeButton = document.getElementById('back-home');

                if (previousPage && previousPage !== window.location.href) {
                    backHomeButton.href = previousPage;
                } else {
                    backHomeButton.href = '/ISD_project_ongit/ISD_project/client_side/home.php';
                }
            </script>

           
        </div>
    </div>
</body>

</html>